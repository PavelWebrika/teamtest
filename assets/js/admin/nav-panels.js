( function ( $ ) {
	'use strict';

	function collapseNavPanelRows() {
		$( '.acf-field-field_nav_panels' )
			.find( '> .acf-input > .acf-repeater > .acf-table > tbody > .acf-row' )
			.not( '.acf-clone' )
			.addClass( '-collapsed' );
	}

	function toggleMegaLinkFields( $context ) {
		var $scope = $context && $context.length ? $context : $( document );

		$scope.find( '.acf-field-field_nav_mega_col_links .acf-row' ).not( '.acf-clone' ).each( function () {
			var $row  = $( this );
			var type  = $row.find( '.acf-field-field_nav_mega_link_type input:checked' ).val() || 'internal';
			var $path = $row.find( '.acf-field-field_nav_mega_link_path' );
			var $url  = $row.find( '.acf-field-field_nav_mega_link_url' );

			if ( 'internal' === type ) {
				$path.removeClass( 'acf-hidden' ).show();
				$url.addClass( 'acf-hidden' ).hide();
			} else {
				$path.addClass( 'acf-hidden' ).hide();
				$url.removeClass( 'acf-hidden' ).show();
			}
		} );
	}

	if ( typeof acf !== 'undefined' ) {
		acf.addAction( 'ready', function () {
			collapseNavPanelRows();
			toggleMegaLinkFields();
		} );
		acf.addAction( 'append', function ( $el ) {
			toggleMegaLinkFields( $el );
		} );
	}

	$( document ).on( 'change', '.acf-field-field_nav_mega_link_type input', function () {
		toggleMegaLinkFields( $( this ).closest( '.acf-row' ) );
	} );
}( jQuery ) );
