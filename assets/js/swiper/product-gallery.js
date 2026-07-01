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
	var resizeTimer  = null;

	function getMobileThumbSpaceBetween() {
		var slides = thumbsEl.querySelectorAll( '.swiper-slide' );
		var count  = slides.length;

		if ( count <= 1 ) {
			return 0;
		}

		var slideWidth     = slides[0] ? slides[0].offsetWidth : 80;
		var containerWidth = thumbsEl.clientWidth;
		var minGap         = 8;
		var totalMinWidth  = ( count * slideWidth ) + ( ( count - 1 ) * minGap );

		if ( totalMinWidth >= containerWidth ) {
			return minGap;
		}

		return ( containerWidth - ( count * slideWidth ) ) / ( count - 1 );
	}

	function updateMobileThumbSpacing() {
		if ( ! thumbsSwiper || ! mq.matches ) {
			return;
		}

		var space = getMobileThumbSpaceBetween();

		if ( thumbsSwiper.params.spaceBetween !== space ) {
			thumbsSwiper.params.spaceBetween = space;
			thumbsSwiper.update();
		}
	}

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
			spaceBetween:        isMobile ? getMobileThumbSpaceBetween() : 8,
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

		if ( isMobile ) {
			window.requestAnimationFrame( updateMobileThumbSpacing );
		}
	}

	function rebuildSwipers() {
		destroySwipers();
		initSwipers();
	}

	rebuildSwipers();

	mq.addEventListener( 'change', rebuildSwipers );

	window.addEventListener( 'resize', function () {
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( updateMobileThumbSpacing, 100 );
	} );
} )();
