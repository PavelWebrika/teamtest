<?php
/**
 * Product gallery — dual synced sliders.
 *
 * Left column: vertical thumbnail Swiper.
 * Right column: main image Swiper.
 * Clicking a thumbnail advances the main slider.
 * Advancing the main slider scrolls the thumbnail strip.
 *
 * Images come from the product_gallery ACF gallery field.
 * Falls back to the featured image when no gallery is set.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'selecta-product-gallery' );
selecta_enqueue_product_gallery();

$gallery_ids = function_exists( 'get_sub_field' ) ? get_sub_field( 'gallery_images' ) : array();

if ( empty( $gallery_ids ) ) {
	$featured_id = get_post_thumbnail_id();

	if ( $featured_id ) {
		$gallery_ids = array( $featured_id );
	}
}

if ( empty( $gallery_ids ) ) {
	return;
}
?>

<section class="product-gallery-section">
	<div class="container product-gallery-section__inner">
		<div class="product-gallery">

			<div class="product-gallery__thumbs-col">
				<button type="button" class="product-gallery__thumbs-nav product-gallery__thumbs-nav--prev" aria-label="<?php esc_attr_e( 'Previous image', 'selecta-theme' ); ?>">
					<svg class="product-gallery__thumbs-nav-icon" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M14.1836 7.34871C13.8814 7.67105 13.3751 7.68737 13.0528 7.38519L7.19998 1.89814L1.34718 7.38519C1.02478 7.68737 0.518535 7.67105 0.216294 7.34871C-0.085785 7.02638 -0.0694648 6.52011 0.252775 6.21793L6.65282 0.21788C6.96055 -0.0705999 7.4394 -0.0705999 7.74713 0.21788L14.1471 6.21793C14.4695 6.5201 14.4858 7.02638 14.1836 7.34871Z" fill="#4C4D4F"/>
					</svg>
				</button>

				<div class="swiper product-gallery-thumbs">
					<div class="swiper-wrapper">

						<?php foreach ( $gallery_ids as $image_id ) : ?>
							<div class="swiper-slide">
								<?php
								echo wp_get_attachment_image(
									(int) $image_id,
									'thumbnail',
									false,
									array( 'class' => 'product-gallery__thumb-img' )
								);
								?>
							</div>
						<?php endforeach; ?>

					</div>
				</div>

				<button type="button" class="product-gallery__thumbs-nav product-gallery__thumbs-nav--next" aria-label="<?php esc_attr_e( 'Next image', 'selecta-theme' ); ?>">
					<svg class="product-gallery__thumbs-nav-icon" width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M14.1836 7.34871C13.8814 7.67105 13.3751 7.68737 13.0528 7.38519L7.19998 1.89814L1.34718 7.38519C1.02478 7.68737 0.518535 7.67105 0.216294 7.34871C-0.085785 7.02638 -0.0694648 6.52011 0.252775 6.21793L6.65282 0.21788C6.96055 -0.0705999 7.4394 -0.0705999 7.74713 0.21788L14.1471 6.21793C14.4695 6.5201 14.4858 7.02638 14.1836 7.34871Z" fill="#4C4D4F"/>
					</svg>
				</button>
			</div>

			<div class="product-gallery__main-col">
				<div class="swiper product-gallery-main">
					<div class="swiper-wrapper">

						<?php foreach ( $gallery_ids as $image_id ) : ?>
							<div class="swiper-slide">
								<?php
								echo wp_get_attachment_image(
									(int) $image_id,
									'large',
									false,
									array( 'class' => 'product-gallery__main-img' )
								);
								?>
							</div>
						<?php endforeach; ?>

					</div>
				</div>
			</div>

		</div>
	</div>
</section>
