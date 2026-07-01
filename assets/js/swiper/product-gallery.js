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
		slidesPerView:       'auto',
		spaceBetween:        8,
		watchSlidesProgress: true,
		loop:                false,
	} );

	new Swiper( mainEl, {
		slidesPerView: 1,
		loop:          false,
		thumbs: {
			swiper: thumbsSwiper,
		},
	} );
} )();
