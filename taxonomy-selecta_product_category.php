<?php
/**
 * Product category taxonomy archive template.
 *
 * @package SelectaTheme
 */

get_header();

wp_enqueue_style( 'selecta-product-card' );

$term = get_queried_object();
$term = $term instanceof WP_Term ? $term : null;
?>

<main id="main" class="site-main product-archive">

	<?php
	get_template_part(
		'template-parts/components/category-banner',
		null,
		array(
			'term' => $term,
		)
	);

	get_template_part(
		'template-parts/components/category-intro',
		null,
		array(
			'term' => $term,
		)
	);
	?>

	<div class="container">
		<?php get_template_part( 'template-parts/components/product-archive-loop' ); ?>
	</div>
</main>

<?php get_footer(); ?>
