<?php
/**
 * Default page template.
 *
 * @package SelectaTheme
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container">

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>
				<h1 class="page-content__title"><?php the_title(); ?></h1>
				<div class="page-content__body">
					<?php the_content(); ?>
				</div>
			</article>

		<?php endwhile; ?>

	</div>
</main>

<?php get_footer(); ?>
