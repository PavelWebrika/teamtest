<?php
/**
 * Product archive template.
 *
 * Lists all selecta_product entries as a responsive card grid.
 *
 * @package SelectaTheme
 */

get_header();

wp_enqueue_style( 'selecta-product-card' );
?>

<main id="main" class="site-main product-archive">
	<div class="container">

		<header class="product-archive__header">
			<h1 class="product-archive__title">
				<?php post_type_archive_title(); ?>
			</h1>
		</header>

		<?php if ( have_posts() ) : ?>

			<ul class="product-grid" role="list">

				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<li class="product-grid__item">
						<?php get_template_part( 'template-parts/components/product-card' ); ?>
					</li>

				<?php endwhile; ?>

			</ul>

			<?php the_posts_pagination( array(
				'prev_text' => esc_html__( '&larr; Previous', 'selecta-theme' ),
				'next_text' => esc_html__( 'Next &rarr;', 'selecta-theme' ),
			) ); ?>

		<?php else : ?>

			<p class="product-archive__empty">
				<?php esc_html_e( 'No products found.', 'selecta-theme' ); ?>
			</p>

		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
