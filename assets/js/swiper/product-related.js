( function () {
	'use strict';

	if ( typeof Swiper === 'undefined' ) {
		return;
	}

	var sections = document.querySelectorAll( '.product-related' );

	if ( ! sections.length ) {
		return;
	}

	var desktopMq = window.matchMedia( '(min-width: 768px)' );

	function updateNavVisibility( section ) {
		var count     = parseInt( section.getAttribute( 'data-slide-count' ), 10 ) || 0;
		var threshold = desktopMq.matches ? 4 : 3;

		section.classList.toggle( 'product-related--show-nav', count > threshold );
	}

	sections.forEach( function ( section ) {
		var swiperEl = section.querySelector( '.product-related-swiper' );

		if ( ! swiperEl ) {
			return;
		}

		updateNavVisibility( section );

		new Swiper( swiperEl, {
			slidesPerView: 2,
			spaceBetween: 10,
			watchOverflow: true,
			navigation: {
				prevEl: section.querySelector( '.product-related__nav--prev' ),
				nextEl: section.querySelector( '.product-related__nav--next' ),
			},
			breakpoints: {
				768: {
					slidesPerView: 4,
					spaceBetween: 26,
				},
			},
		} );
	} );

	desktopMq.addEventListener( 'change', function () {
		sections.forEach( updateNavVisibility );
	} );
} )();
