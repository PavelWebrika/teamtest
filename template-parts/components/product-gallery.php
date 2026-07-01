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

<div class="product-gallery">
	<div class="product-gallery__thumbs-col">

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
