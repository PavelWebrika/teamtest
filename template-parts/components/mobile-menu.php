<?php
/**
 * Mobile menu drawer.
 *
 * Slide-in drawer for the primary navigation on screens below 1024px.
 * Triggered by .site-header__burger in site-header-bar.php.
 *
 * @package SelectaTheme
 */

wp_enqueue_style( 'selecta-mobile-menu' );

$logo_id           = selecta_get_field( 'nav_header_logo', 'option' );
$store_locator_url = selecta_get_field( 'nav_store_locator_url', 'option' );
$has_primary_menu  = has_nav_menu( 'primary' );
?>
<div
	class="mobile-menu"
	id="mobile-menu"
	aria-hidden="true"
>
	<div class="mobile-menu__overlay" aria-hidden="true"></div>

	<div
		class="mobile-menu__drawer"
		role="dialog"
		aria-modal="true"
		aria-label="<?php esc_attr_e( 'Navigation menu', 'selecta-theme' ); ?>"
	>
		<div class="mobile-menu__header">
			<button
				type="button"
				class="mobile-menu__close"
				aria-label="<?php esc_attr_e( 'Close menu', 'selecta-theme' ); ?>"
			>
				<?php echo selecta_get_svg( 'close' ); ?>
			</button>

			<a class="mobile-menu__logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( $logo_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						(int) $logo_id,
						'medium',
						false,
						array(
							'class' => 'mobile-menu__logo-image',
							'alt'   => get_bloginfo( 'name' ),
						)
					);
					?>
				<?php else : ?>
					<span class="mobile-menu__logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				<?php endif; ?>
			</a>

			<span class="mobile-menu__header-spacer" aria-hidden="true"></span>
		</div>

		<?php if ( $has_primary_menu ) : ?>
			<nav class="mobile-menu__nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'selecta-theme' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'nav-menu',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>

		<?php if ( $store_locator_url ) : ?>
			<div class="mobile-menu__store">
				<a class="mobile-menu__store-link" href="<?php echo esc_url( $store_locator_url ); ?>">
					<span class="mobile-menu__store-icon" aria-hidden="true">
						<?php echo selecta_get_svg( 'store-locator' ); ?>
					</span>
					<span><?php esc_html_e( 'Точки на продажба', 'selecta-theme' ); ?></span>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>
