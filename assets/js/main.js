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
		}
	} );

	// -------------------------------------------------------
	// Mobile menu toggle
	// Will be implemented in Phase 2 (mobile menu component).
	// -------------------------------------------------------

} )();
