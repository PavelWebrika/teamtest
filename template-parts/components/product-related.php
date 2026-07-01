<?php
/**
 * "You May Also Like" section.
 *
 * Reads the related_products Relationship field from the current product
 * and renders a row of product cards. Silently exits when no products
 * are selected or ACF is inactive.
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
?>

<section class="product-related">
	<div class="product-related__inner container">
		<h2 class="product-related__heading"><?php esc_html_e( 'Може да ви хареса и', 'selecta-theme' ); ?></h2>
		<div class="product-related__grid">
			<?php while ( $related_query->have_posts() ) : ?>
				<?php $related_query->the_post(); ?>
				<?php get_template_part( 'template-parts/components/product-card' ); ?>
			<?php endwhile; ?>
		</div>
	</div>
</section>

<?php
wp_reset_postdata();
