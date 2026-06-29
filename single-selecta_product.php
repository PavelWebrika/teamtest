<?php
/**
 * Single product template.
 *
 * Renders a selecta_product CPT entry using the product_sections
 * flexible content field. Each section layout is dispatched through
 * template-parts/layouts/product-flexible-content.php.
 *
 * @package SelectaTheme
 */

get_header();
?>

<main id="main" class="site-main product-page">

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<?php get_template_part( 'template-parts/layouts/product-flexible-content' ); ?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
