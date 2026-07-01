( function () {
	'use strict';

	if ( typeof Swiper === 'undefined' ) {
		return;
	}

	var swipers = document.querySelectorAll( '.product-carousel__swiper' );

	if ( ! swipers.length ) {
		return;
	}

	swipers.forEach( function ( el ) {
		new Swiper( el, {
			slidesPerView: 1.2,
			spaceBetween: 16,
			loop: false,
			breakpoints: {
				640: {
					slidesPerView: 2.2,
					spaceBetween: 20,
				},
				1024: {
					slidesPerView: 4,
					spaceBetween: 24,
				},
			},
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
