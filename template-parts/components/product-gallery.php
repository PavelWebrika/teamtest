<?php
/**
 * Product hero — gallery (left) + info (right).
 *
 * Left column: vertical thumbnail Swiper + main image Swiper (synced).
 * Right column: product title, subtitle, tag, description, variants.
 *
 * Images come from the gallery_images ACF sub-field.
 * All other info fields are ACF sub-fields or native WP data.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'selecta-product-gallery' );
wp_enqueue_style( 'selecta-product-hero-info' );
selecta_enqueue_product_gallery();

$gallery_ids = function_exists( 'get_sub_field' ) ? get_sub_field( 'gallery_images' ) : array();

if ( empty( $gallery_ids ) ) {
	$featured_id = get_post_thumbnail_id();

	if ( $featured_id ) {
		$gallery_ids = array( $featured_id );
	}
}

$product_badge = selecta_get_field( 'product_badge', get_the_ID() );
?>

<section class="product-hero-section">
	<div class="container product-hero-section__inner">

		<?php if ( ! empty( $gallery_ids ) ) : ?>
		<div class="product-gallery">

			<div class="product-gallery__thumbs-col">
				<button type="button" class="product-gallery__thumbs-nav product-gallery__thumbs-nav--prev" aria-label="<?php esc_attr_e( 'Previous image', 'selecta-theme' ); ?>">
					<span class="product-gallery__thumbs-nav-icon">
						<?php echo selecta_get_svg( 'chevron-up' ); ?>
					</span>
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
					<span class="product-gallery__thumbs-nav-icon">
						<?php echo selecta_get_svg( 'chevron-up' ); ?>
					</span>
				</button>
			</div>

			<div class="product-gallery__main-col">
				<?php if ( $product_badge ) : ?>
					<span class="product-gallery__badge"><?php echo esc_html( $product_badge ); ?></span>
				<?php endif; ?>

				<button type="button" class="product-gallery__main-nav product-gallery__main-nav--prev" aria-label="<?php esc_attr_e( 'Previous image', 'selecta-theme' ); ?>">
					<span class="product-gallery__main-nav-icon product-gallery__main-nav-icon--prev">
						<?php echo selecta_get_svg( 'chevron-up' ); ?>
					</span>
				</button>

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

				<button type="button" class="product-gallery__main-nav product-gallery__main-nav--next" aria-label="<?php esc_attr_e( 'Next image', 'selecta-theme' ); ?>">
					<span class="product-gallery__main-nav-icon product-gallery__main-nav-icon--next">
						<?php echo selecta_get_svg( 'chevron-up' ); ?>
					</span>
				</button>
			</div>

		</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/components/product-hero-info' ); ?>

	</div>
</section>
