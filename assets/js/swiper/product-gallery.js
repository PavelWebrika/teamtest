( function () {
	'use strict';

	if ( typeof Swiper === 'undefined' ) {
		return;
	}

	var gallery = document.querySelector( '.product-gallery' );

	if ( ! gallery ) {
		return;
	}

	var thumbsEl = gallery.querySelector( '.product-gallery-thumbs' );
	var mainEl   = gallery.querySelector( '.product-gallery-main' );

	if ( ! thumbsEl || ! mainEl ) {
		return;
	}

	var thumbsSwiper = new Swiper( thumbsEl, {
		direction:           'vertical',
		slidesPerView:       4,
		spaceBetween:        8,
		watchSlidesProgress: true,
		loop:                false,
		freeMode:            false,
	} );

	new Swiper( mainEl, {
		slidesPerView: 1,
		loop:          false,
		thumbs: {
			swiper: thumbsSwiper,
		},
	} );
} )();
