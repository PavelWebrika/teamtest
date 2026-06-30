( function () {
	'use strict';

	if ( ! window.selectaSearch ) {
		return;
	}

	var REST_URL    = window.selectaSearch.restUrl;
	var MIN_CHARS   = window.selectaSearch.minChars   || 3;
	var DEBOUNCE_MS = window.selectaSearch.debounceMs || 250;

	var searchBtn   = document.querySelector( '.site-header__action--search' );
	var overlay     = document.getElementById( 'search-overlay' );
	var backdrop    = overlay ? overlay.querySelector( '.search-overlay__backdrop' ) : null;
	var panel       = overlay ? overlay.querySelector( '.search-overlay__panel' ) : null;
	var closeBtn    = document.getElementById( 'search-close' );
	var searchInput = document.getElementById( 'search-input' );
	var resultsList = document.getElementById( 'search-results' );
	var loadingEl   = document.getElementById( 'search-loading' );
	var emptyEl     = document.getElementById( 'search-no-results' );
	var countEl     = document.getElementById( 'search-count' );

	if ( ! overlay || ! searchBtn || ! closeBtn || ! searchInput || ! resultsList ) {
		return;
	}

	var debounceTimer = null;
	var currentQuery  = '';
	var siteHeader    = document.querySelector( '.site-header' );
	var starTemplate  = document.getElementById( 'selecta-search-star-template' );
	var starMarkup    = starTemplate ? starTemplate.innerHTML : '';
	var mobileMq      = window.matchMedia( '(max-width: 64rem)' );

	function isMobileSearch() {
		return mobileMq.matches;
	}

	function finishClose() {
		overlay.hidden = true;
		overlay.classList.remove( 'is-open', 'is-closing' );
		searchBtn.setAttribute( 'aria-expanded', 'false' );
		document.body.style.overflow = '';
		searchBtn.focus();
	}

	function createStarsRow( score ) {
		if ( ! starMarkup || typeof score !== 'number' || isNaN( score ) ) {
			return null;
		}

		var clamped  = Math.max( 0, Math.min( 5, score ) );
		var fillPct  = Math.round( ( clamped / 5 ) * 10000 ) / 100;
		var fiveStars = '';

		for ( var i = 0; i < 5; i++ ) {
			fiveStars += starMarkup;
		}

		var row = document.createElement( 'div' );
		row.className = 'search-overlay__stars-row';

		var stars = document.createElement( 'div' );
		stars.className = 'search-overlay__stars';
		stars.setAttribute( 'role', 'img' );
		stars.setAttribute( 'aria-label', 'Score: ' + clamped + ' out of 5' );

		var empty = document.createElement( 'span' );
		empty.className = 'search-overlay__stars-empty';
		empty.setAttribute( 'aria-hidden', 'true' );
		empty.insertAdjacentHTML( 'afterbegin', fiveStars );

		var filled = document.createElement( 'span' );
		filled.className = 'search-overlay__stars-filled';
		filled.setAttribute( 'aria-hidden', 'true' );
		filled.style.width = fillPct + '%';
		filled.insertAdjacentHTML( 'afterbegin', fiveStars );

		stars.appendChild( empty );
		stars.appendChild( filled );

		var scoreEl = document.createElement( 'span' );
		scoreEl.className = 'search-overlay__score';
		scoreEl.setAttribute( 'aria-hidden', 'true' );
		scoreEl.textContent = String( clamped );

		row.appendChild( stars );
		row.appendChild( scoreEl );

		return row;
	}

	function updateOverlayTop() {
		if ( ! siteHeader || isMobileSearch() ) {
			return;
		}

		var top = siteHeader.getBoundingClientRect().bottom;
		overlay.style.setProperty( '--search-overlay-top', top + 'px' );
	}

	// ---------------------------------------------------
	// Open / close
	// ---------------------------------------------------

	function openOverlay() {
		updateOverlayTop();
		overlay.hidden = false;
		overlay.classList.remove( 'is-closing' );
		overlay.classList.add( 'is-open' );
		searchBtn.setAttribute( 'aria-expanded', 'true' );
		document.body.style.overflow = 'hidden';
		searchInput.focus();
	}

	function closeOverlay() {
		if ( isMobileSearch() && overlay.classList.contains( 'is-open' ) && panel ) {
			overlay.classList.remove( 'is-open' );
			overlay.classList.add( 'is-closing' );

			if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
				finishClose();
				return;
			}

			panel.addEventListener( 'animationend', function onDone( e ) {
				if ( e.target !== panel ) {
					return;
				}

				panel.removeEventListener( 'animationend', onDone );
				finishClose();
			} );

			return;
		}

		finishClose();
	}

	function clearResults() {
		resultsList.innerHTML = '';
		if ( loadingEl ) { loadingEl.hidden = true; }
		if ( emptyEl )   { emptyEl.hidden   = true; }
		if ( countEl )   { countEl.hidden   = true; }
		resultsList.removeAttribute( 'aria-busy' );
	}

	searchBtn.addEventListener( 'click', openOverlay );
	closeBtn.addEventListener( 'click', closeOverlay );

	if ( backdrop ) {
		backdrop.addEventListener( 'click', closeOverlay );
	}

	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' && ! overlay.hidden ) {
			closeOverlay();
		}
	} );

	window.addEventListener( 'resize', function () {
		if ( ! overlay.hidden ) {
			updateOverlayTop();
		}
	} );

	// ---------------------------------------------------
	// Focus trap
	// ---------------------------------------------------

	function getFocusable() {
		return Array.from(
			overlay.querySelectorAll(
				'a[href], button:not([disabled]), input, [tabindex]:not([tabindex="-1"])'
			)
		).filter( function ( el ) {
			return ! el.closest( '[hidden]' ) && el.offsetParent !== null;
		} );
	}

	overlay.addEventListener( 'keydown', function ( e ) {
		if ( e.key !== 'Tab' ) {
			return;
		}

		var focusable = getFocusable();
		if ( ! focusable.length ) {
			e.preventDefault();
			return;
		}

		var first = focusable[ 0 ];
		var last  = focusable[ focusable.length - 1 ];

		if ( e.shiftKey ) {
			if ( document.activeElement === first ) {
				e.preventDefault();
				last.focus();
			}
		} else {
			if ( document.activeElement === last ) {
				e.preventDefault();
				first.focus();
			}
		}
	} );

	// ---------------------------------------------------
	// Input — debounced fetch
	// ---------------------------------------------------

	searchInput.addEventListener( 'input', function () {
		var val = searchInput.value.trim();

		clearTimeout( debounceTimer );

		if ( val.length < MIN_CHARS ) {
			clearResults();
			currentQuery = '';
			return;
		}

		debounceTimer = setTimeout( function () {
			fetchResults( val );
		}, DEBOUNCE_MS );
	} );

	// ---------------------------------------------------
	// Fetch
	// ---------------------------------------------------

	function fetchResults( query ) {
		currentQuery = query;

		clearResults();
		if ( loadingEl ) { loadingEl.hidden = false; }
		resultsList.setAttribute( 'aria-busy', 'true' );

		var url = REST_URL + '?q=' + encodeURIComponent( query );

		fetch( url )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( data ) {
				if ( loadingEl ) { loadingEl.hidden = true; }
				resultsList.removeAttribute( 'aria-busy' );

				if ( searchInput.value.trim() !== query ) {
					return;
				}

				renderResults( data );
			} )
			.catch( function () {
				if ( loadingEl ) { loadingEl.hidden = true; }
				resultsList.removeAttribute( 'aria-busy' );
			} );
	}

	// ---------------------------------------------------
	// Render
	// ---------------------------------------------------

	function renderResults( items ) {
		resultsList.innerHTML = '';

		if ( ! Array.isArray( items ) || items.length === 0 ) {
			if ( emptyEl ) { emptyEl.hidden = false; }
			if ( countEl ) { countEl.hidden = true; }
			return;
		}

		if ( emptyEl ) { emptyEl.hidden = true; }

		if ( countEl ) {
			countEl.textContent = items.length + ( items.length === 1 ? ' резултат' : ' резултата' );
			countEl.hidden = false;
		}

		items.forEach( function ( item ) {
			var li = document.createElement( 'li' );

			var a = document.createElement( 'a' );
			a.className = 'search-overlay__result-link';
			a.href = item.url || '#';

			var imageWrap = document.createElement( 'span' );
			imageWrap.className = 'search-overlay__result-image';

			if ( item.image_url ) {
				var img = document.createElement( 'img' );
				img.src    = item.image_url;
				img.alt    = item.image_alt || '';
				img.width  = 88;
				img.height = 88;
				imageWrap.appendChild( img );
			} else {
				var placeholder = document.createElement( 'span' );
				placeholder.className = 'search-overlay__result-image-placeholder';
				imageWrap.appendChild( placeholder );
			}

			a.appendChild( imageWrap );

			var body = document.createElement( 'span' );
			body.className = 'search-overlay__result-body';

			if ( item.line ) {
				var lineEl = document.createElement( 'span' );
				lineEl.className = 'search-overlay__result-line';
				lineEl.textContent = item.line;
				body.appendChild( lineEl );
			}

			var titleEl = document.createElement( 'span' );
			titleEl.className = 'search-overlay__result-title';
			titleEl.textContent = item.title || '';
			body.appendChild( titleEl );

			if ( item.benefit ) {
				var benefitEl = document.createElement( 'span' );
				benefitEl.className = 'search-overlay__result-benefit';
				benefitEl.textContent = item.benefit;
				body.appendChild( benefitEl );
			}

			if ( typeof item.score === 'number' && ! isNaN( item.score ) ) {
				var starsRow = createStarsRow( item.score );
				if ( starsRow ) {
					body.appendChild( starsRow );
				}
			}

			a.appendChild( body );

			if ( item.price ) {
				var priceEl = document.createElement( 'span' );
				priceEl.className = 'search-overlay__result-price';
				priceEl.textContent = item.price;
				a.appendChild( priceEl );
			}

			var arrow = document.createElement( 'span' );
			arrow.className = 'search-overlay__result-arrow';
			arrow.setAttribute( 'aria-hidden', 'true' );
			arrow.textContent = '→';
			a.appendChild( arrow );

			a.addEventListener( 'click', closeOverlay );

			li.appendChild( a );
			resultsList.appendChild( li );
		} );
	}

} )();
