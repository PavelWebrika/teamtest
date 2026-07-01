( function () {
	'use strict';

	if ( typeof Swiper === 'undefined' ) {
		return;
	}

	var gallery = document.querySelector( '.product-gallery' );

	if ( ! gallery ) {
		return;
	}

	var mq         = window.matchMedia( '(max-width: 1023px)' );
	var thumbsEl   = gallery.querySelector( '.product-gallery-thumbs' );
	var mainEl     = gallery.querySelector( '.product-gallery-main' );
	var thumbsPrev = gallery.querySelector( '.product-gallery__thumbs-nav--prev' );
	var thumbsNext = gallery.querySelector( '.product-gallery__thumbs-nav--next' );
	var mainPrev   = gallery.querySelector( '.product-gallery__main-nav--prev' );
	var mainNext   = gallery.querySelector( '.product-gallery__main-nav--next' );

	if ( ! thumbsEl || ! mainEl ) {
		return;
	}

	var thumbsSwiper = null;
	var mainSwiper   = null;

	function destroySwipers() {
		if ( mainSwiper ) {
			mainSwiper.destroy( true, true );
			mainSwiper = null;
		}

		if ( thumbsSwiper ) {
			thumbsSwiper.destroy( true, true );
			thumbsSwiper = null;
		}
	}

	function initSwipers() {
		var isMobile = mq.matches;

		thumbsSwiper = new Swiper( thumbsEl, {
			direction:           isMobile ? 'horizontal' : 'vertical',
			slidesPerView:       'auto',
			spaceBetween:        8,
			watchSlidesProgress: true,
			loop:                false,
			navigation:          isMobile
				? false
				: {
					prevEl: thumbsPrev,
					nextEl: thumbsNext,
				},
		} );

		mainSwiper = new Swiper( mainEl, {
			slidesPerView: 1,
			loop:          false,
			navigation:    isMobile
				? {
					prevEl: mainPrev,
					nextEl: mainNext,
				}
				: false,
			thumbs: {
				swiper: thumbsSwiper,
			},
		} );
	}

	function rebuildSwipers() {
		destroySwipers();
		initSwipers();
	}

	rebuildSwipers();

	mq.addEventListener( 'change', rebuildSwipers );
} )();
