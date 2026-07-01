( function () {
	'use strict';

	if ( typeof Swiper === 'undefined' ) {
		return;
	}

	var swipers = document.querySelectorAll( '.image_content_swiper' );

	if ( ! swipers.length ) {
		return;
	}

	swipers.forEach( function ( el ) {
		new Swiper( el, {
			slidesPerView: 1,
			loop: true,
			pagination: {
				el: el.querySelector( '.swiper-pagination' ),
				clickable: true,
			},
			navigation: {
				nextEl: el.querySelector( '.swiper-button-next' ),
				prevEl: el.querySelector( '.swiper-button-prev' ),
			},
		} );
	} );
} )();
