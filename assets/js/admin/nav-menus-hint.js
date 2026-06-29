( function () {
	'use strict';

	var hintText = '⚠ For nav panels: CSS class must start with panel-key- e.g. panel-key-products';

	function createHint() {
		var hint = document.createElement( 'p' );
		hint.className = 'selecta-nav-menu-class-hint';
		hint.textContent = hintText;
		return hint;
	}

	function addHints() {
		document.querySelectorAll( '.edit-menu-item-classes' ).forEach( function ( input ) {
			if ( input.dataset.panelHint ) {
				return;
			}

			input.dataset.panelHint = '1';
			input.parentNode.appendChild( createHint() );
		} );
	}

	addHints();

	document.addEventListener( 'click', function ( e ) {
		if ( e.target && e.target.matches( '.item-add' ) ) {
			setTimeout( addHints, 400 );
		}
	} );
}() );
