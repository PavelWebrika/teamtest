( function () {
	'use strict';

	// -------------------------------------------------------
	// Header navigation panels
	// -------------------------------------------------------

	var header      = document.querySelector( '.site-header' );
	var navItems    = document.querySelectorAll( '.site-header__nav .nav-menu > li' );
	var allPanels   = document.querySelectorAll( '.nav-panel' );
	var activeItem  = null;

	function closeAllPanels() {
		allPanels.forEach( function ( panel ) {
			panel.hidden = true;
		} );
		navItems.forEach( function ( item ) {
			var link = item.querySelector( 'a' );
			if ( link ) {
				link.removeAttribute( 'aria-expanded' );
			}
		} );
		activeItem = null;
	}

	function getPanelKey( item ) {
		var classes = Array.from( item.classList );
		var match   = classes.find( function ( cls ) {
			return cls.indexOf( 'panel-key-' ) === 0;
		} );
		return match || null;
	}

	navItems.forEach( function ( item ) {
		var panelKey = getPanelKey( item );
		if ( ! panelKey ) {
			return;
		}

		var panel = document.querySelector( '.nav-panel[data-panel="' + panelKey + '"]' );
		if ( ! panel ) {
			return;
		}

		var link = item.querySelector( 'a' );
		if ( link ) {
			link.setAttribute( 'aria-haspopup', 'true' );
			link.setAttribute( 'aria-expanded', 'false' );
		}

		item.addEventListener( 'mouseenter', function () {
			if ( activeItem === item ) {
				return;
			}
			closeAllPanels();
			panel.hidden = false;
			if ( link ) {
				link.setAttribute( 'aria-expanded', 'true' );
			}
			activeItem = item;
		} );
	} );

	if ( header ) {
		header.addEventListener( 'mouseleave', closeAllPanels );
	}

	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' ) {
			closeAllPanels();
			closeMobileMenu();
		}
	} );

	// -------------------------------------------------------
	// Mobile menu — drawer open / close
	// -------------------------------------------------------

	var mobileMenu    = document.getElementById( 'mobile-menu' );
	var mobileOverlay = mobileMenu ? mobileMenu.querySelector( '.mobile-menu__overlay' ) : null;
	var mobileClose   = mobileMenu ? mobileMenu.querySelector( '.mobile-menu__close' )   : null;
	var mobileDrawer  = mobileMenu ? mobileMenu.querySelector( '.mobile-menu__drawer' )  : null;
	var mobileBurger  = document.querySelector( '.site-header__burger' );

	function openMobileMenu() {
		if ( ! mobileMenu || mobileMenu.classList.contains( 'is-open' ) ) {
			return;
		}
		mobileMenu.classList.remove( 'is-closing' );
		mobileMenu.classList.add( 'is-open' );
		document.body.classList.add( 'mobile-menu-open' );
		if ( mobileBurger ) {
			mobileBurger.setAttribute( 'aria-expanded', 'true' );
		}
		if ( mobileClose ) {
			mobileClose.focus();
		}
	}

	function closeMobileMenu() {
		if ( ! mobileMenu || ! mobileMenu.classList.contains( 'is-open' ) ) {
			return;
		}
		mobileMenu.classList.remove( 'is-open' );
		mobileMenu.classList.add( 'is-closing' );
		document.body.classList.remove( 'mobile-menu-open' );
		if ( mobileBurger ) {
			mobileBurger.setAttribute( 'aria-expanded', 'false' );
		}
		if ( mobileDrawer ) {
			mobileDrawer.addEventListener( 'animationend', function onDone() {
				mobileDrawer.removeEventListener( 'animationend', onDone );
				mobileMenu.classList.remove( 'is-closing' );
				if ( mobileBurger ) {
					mobileBurger.focus();
				}
			} );
		}
	}

	if ( mobileBurger ) {
		mobileBurger.addEventListener( 'click', openMobileMenu );
	}

	if ( mobileOverlay ) {
		mobileOverlay.addEventListener( 'click', closeMobileMenu );
	}

	if ( mobileClose ) {
		mobileClose.addEventListener( 'click', closeMobileMenu );
	}

	// -------------------------------------------------------
	// Mobile menu — sub-menu accordion
	// -------------------------------------------------------

	var mobileNavParents = mobileMenu
		? mobileMenu.querySelectorAll( '.mobile-menu__nav .menu-item-has-children' )
		: [];

	mobileNavParents.forEach( function ( item ) {
		var link = item.querySelector( ':scope > a' );
		if ( ! link ) {
			return;
		}

		link.setAttribute( 'aria-expanded', 'false' );

		link.addEventListener( 'click', function ( e ) {
			e.preventDefault();

			var isExpanded = 'true' === link.getAttribute( 'aria-expanded' );

			mobileNavParents.forEach( function ( other ) {
				if ( other === item ) {
					return;
				}
				other.classList.remove( 'is-expanded' );
				var otherLink = other.querySelector( ':scope > a' );
				if ( otherLink ) {
					otherLink.setAttribute( 'aria-expanded', 'false' );
				}
			} );

			item.classList.toggle( 'is-expanded', ! isExpanded );
			link.setAttribute( 'aria-expanded', isExpanded ? 'false' : 'true' );
		} );
	} );

} )();
