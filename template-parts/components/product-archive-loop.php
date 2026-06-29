<?php
/**
 * Product archive grid loop.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( have_posts() ) :
	?>

	<ul class="product-grid" role="list">

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<li class="product-grid__item">
				<?php get_template_part( 'template-parts/components/product-card' ); ?>
			</li>

		<?php endwhile; ?>

	</ul>

	<?php
	the_posts_pagination(
		array(
			'prev_text' => esc_html__( '&larr; Previous', 'selecta-theme' ),
			'next_text' => esc_html__( 'Next &rarr;', 'selecta-theme' ),
		)
	);

else :
	?>

	<p class="product-archive__empty">
		<?php esc_html_e( 'No products found.', 'selecta-theme' ); ?>
	</p>

	<?php
endif;
