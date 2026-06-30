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
	// Mobile menu — top-level panel accordion (panel-key-* items)
	// -------------------------------------------------------

	var chevronSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="11" height="7" viewBox="0 0 11 7" fill="none" aria-hidden="true" focusable="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.292787 0.305288C0.480314 0.117817 0.734622 0.0125018 0.999786 0.0125018C1.26495 0.0125018 1.51926 0.117817 1.70679 0.305288L4.99979 3.59829L8.29279 0.305288C8.38503 0.209778 8.49538 0.133596 8.61738 0.0811869C8.73939 0.0287779 8.87061 0.00119157 9.00339 3.77571e-05C9.13616 -0.00111606 9.26784 0.0241854 9.39074 0.0744663C9.51364 0.124747 9.62529 0.199 9.71918 0.292893C9.81307 0.386786 9.88733 0.498438 9.93761 0.621334C9.98789 0.744231 10.0132 0.87591 10.012 1.00869C10.0109 1.14147 9.9833 1.27269 9.93089 1.39469C9.87848 1.5167 9.8023 1.62704 9.70679 1.71929L5.70679 5.71929C5.51926 5.90676 5.26495 6.01207 4.99979 6.01207C4.73462 6.01207 4.48031 5.90676 4.29279 5.71929L0.292787 1.71929C0.105316 1.53176 0 1.27745 0 1.01229C0 0.747124 0.105316 0.492816 0.292787 0.305288Z" fill="currentColor"/></svg>';

	function getPanelKeyFromItem( item ) {
		var classes = Array.from( item.classList );
		var match   = classes.find( function ( cls ) {
			return cls.indexOf( 'panel-key-' ) === 0;
		} );
		return match || null;
	}

	var mobileNavItems = mobileMenu
		? Array.from( mobileMenu.querySelectorAll( '.mobile-menu__nav .nav-menu > li' ) )
		: [];

	var activeMobileItem = null;

	function closeMobileNavItem( navItem ) {
		if ( ! navItem ) {
			return;
		}

		var prevPanel  = navItem.querySelector( '.mobile-nav-panel' );
		var prevToggle = navItem.querySelector( '.mobile-menu__nav-toggle' );

		if ( prevPanel ) {
			prevPanel.hidden = true;
		}
		if ( prevToggle ) {
			prevToggle.setAttribute( 'aria-expanded', 'false' );
		}

		navItem.classList.remove( 'is-expanded' );
	}

	mobileNavItems.forEach( function ( item ) {
		var panelKey = getPanelKeyFromItem( item );
		if ( ! panelKey ) {
			return;
		}

		var panel = mobileMenu.querySelector( '.mobile-nav-panel[data-panel="' + panelKey + '"]' );

		if ( panel ) {
			item.appendChild( panel );
		}

		var link = item.querySelector( ':scope > a' );
		if ( ! link ) {
			return;
		}

		var row = document.createElement( 'div' );
		row.className = 'mobile-menu__nav-row';

		link.parentNode.insertBefore( row, link );
		row.appendChild( link );
		link.classList.add( 'mobile-menu__nav-link' );

		var toggleBtn = document.createElement( 'button' );
		toggleBtn.type = 'button';
		toggleBtn.className = 'mobile-menu__nav-toggle';
		toggleBtn.setAttribute( 'aria-expanded', 'false' );
		toggleBtn.setAttribute(
			'aria-label',
			'Toggle ' + link.textContent.trim() + ' submenu'
		);

		var chevronSpan = document.createElement( 'span' );
		chevronSpan.className = 'mobile-menu__chevron';
		chevronSpan.innerHTML = chevronSVG;
		chevronSpan.setAttribute( 'aria-hidden', 'true' );
		toggleBtn.appendChild( chevronSpan );
		row.appendChild( toggleBtn );

		if ( ! panel ) {
			toggleBtn.hidden = true;
			return;
		}

		toggleBtn.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			e.stopPropagation();

			var isOpen = activeMobileItem === item;

			if ( activeMobileItem && activeMobileItem !== item ) {
				closeMobileNavItem( activeMobileItem );
				activeMobileItem = null;
			}

			if ( ! isOpen ) {
				panel.hidden = false;
				item.classList.add( 'is-expanded' );
				toggleBtn.setAttribute( 'aria-expanded', 'true' );
				activeMobileItem = item;
			} else {
				closeMobileNavItem( item );
				activeMobileItem = null;
			}
		} );
	} );

	// -------------------------------------------------------
	// Mobile menu — nested column toggles inside mega panels
	// -------------------------------------------------------

	var columnToggles = mobileMenu
		? mobileMenu.querySelectorAll( '.mobile-nav-panel__column-toggle' )
		: [];

	columnToggles.forEach( function ( btn ) {
		var chevron = btn.querySelector( '.mobile-nav-panel__column-chevron' );
		if ( chevron ) {
			chevron.innerHTML = chevronSVG;
		}

		btn.addEventListener( 'click', function () {
			var col        = btn.closest( '.mobile-nav-panel__column' );
			var isExpanded = col.classList.contains( 'is-expanded' );
			col.classList.toggle( 'is-expanded', ! isExpanded );
			btn.setAttribute( 'aria-expanded', isExpanded ? 'false' : 'true' );
		} );
	} );

} )();
