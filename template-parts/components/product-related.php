<?php
/**
 * "You May Also Like" section.
 *
 * Reads the related_products Relationship field from the current product
 * and renders a Swiper row of product cards.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$related_ids = get_sub_field( 'related_products' );

if ( empty( $related_ids ) || ! is_array( $related_ids ) ) {
	return;
}

$related_query = new WP_Query(
	array(
		'post_type'      => 'selecta_product',
		'post__in'       => $related_ids,
		'orderby'        => 'post__in',
		'posts_per_page' => count( $related_ids ),
		'no_found_rows'  => true,
	)
);

if ( ! $related_query->have_posts() ) {
	return;
}

wp_enqueue_style( 'selecta-product-card' );
wp_enqueue_style( 'selecta-product-related' );
selecta_enqueue_product_related();
?>

<section class="product-related">
	<div class="product-related__inner container">
		<h2 class="product-related__heading"><?php esc_html_e( 'Може да ви хареса и', 'selecta-theme' ); ?></h2>

		<div class="product-related__controls">
			<button type="button" class="product-related__nav product-related__nav--prev" aria-label="<?php esc_attr_e( 'Previous products', 'selecta-theme' ); ?>">
				<span class="product-related__nav-icon" aria-hidden="true">
					<?php echo selecta_get_svg( 'chevron-left' ); ?>
				</span>
			</button>

			<div class="swiper product-related-swiper">
				<div class="swiper-wrapper">
					<?php while ( $related_query->have_posts() ) : ?>
						<?php $related_query->the_post(); ?>
						<div class="swiper-slide">
							<?php get_template_part( 'template-parts/components/product-card' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
			</div>

			<button type="button" class="product-related__nav product-related__nav--next" aria-label="<?php esc_attr_e( 'Next products', 'selecta-theme' ); ?>">
				<span class="product-related__nav-icon product-related__nav-icon--next" aria-hidden="true">
					<?php echo selecta_get_svg( 'chevron-left' ); ?>
				</span>
			</button>
		</div>
	</div>
</section>

<?php
wp_reset_postdata();
