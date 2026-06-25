<?php
/**
 * 404 template.
 *
 * @package SelectaTheme
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container">
		<div class="error-404">
			<h1 class="error-404__title"><?php esc_html_e( 'Страницата не е намерена', 'selecta-theme' ); ?></h1>
			<p class="error-404__text"><?php esc_html_e( 'Страницата, която търсите, не съществува или е преместена.', 'selecta-theme' ); ?></p>
			<a class="error-404__link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Към началната страница', 'selecta-theme' ); ?>
			</a>
		</div>
	</div>
</main>

<?php get_footer(); ?>
