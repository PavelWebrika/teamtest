<?php
/**
 * Footer template.
 *
 * @package SelectaTheme
 */
?>

<footer class="site-footer">
	<div class="container site-footer__inner">
		<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'selecta-theme' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'menu_class'     => 'nav-menu',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>

		<p class="site-footer__copyright">
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
