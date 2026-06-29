<?php
/**
 * Product category taxonomy archive template.
 *
 * @package SelectaTheme
 */

get_header();

wp_enqueue_style( 'selecta-product-card' );

$term = get_queried_object();
?>

<main id="main" class="site-main product-archive">
	<div class="container">

		<header class="product-archive__header">
			<h1 class="product-archive__title">
				<?php single_term_title(); ?>
			</h1>

			<?php if ( $term instanceof WP_Term && ! empty( $term->description ) ) : ?>
				<div class="product-archive__description">
					<?php echo wp_kses_post( term_description( $term->term_id, $term->taxonomy ) ); ?>
				</div>
			<?php endif; ?>
		</header>

		<?php get_template_part( 'template-parts/components/product-archive-loop' ); ?>

	</div>
</main>

<?php get_footer(); ?>
