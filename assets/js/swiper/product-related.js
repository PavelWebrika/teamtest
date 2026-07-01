( function () {
	'use strict';

	if ( typeof Swiper === 'undefined' ) {
		return;
	}

	var sections = document.querySelectorAll( '.product-related' );

	if ( ! sections.length ) {
		return;
	}

	sections.forEach( function ( section ) {
		var swiperEl = section.querySelector( '.product-related-swiper' );

		if ( ! swiperEl ) {
			return;
		}

		new Swiper( swiperEl, {
			slidesPerView: 1.25,
			spaceBetween: 10,
			watchOverflow: true,
			navigation: {
				prevEl: section.querySelector( '.product-related__nav--prev' ),
				nextEl: section.querySelector( '.product-related__nav--next' ),
			},
			breakpoints: {
				480: {
					slidesPerView: 2,
					spaceBetween: 10,
				},
				768: {
					slidesPerView: 3,
					spaceBetween: 10,
				},
				1024: {
					slidesPerView: 4,
					spaceBetween: 26,
				},
			},
		} );
	} );
} )();
