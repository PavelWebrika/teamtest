<?php
/**
 * Main site header bar — logo, primary nav, utility actions.
 *
 * @package SelectaTheme
 */

wp_enqueue_style( 'selecta-site-header' );

$logo_id              = selecta_get_field( 'nav_header_logo', 'option' );
$store_locator_path   = selecta_get_field( 'nav_store_locator_url', 'option' );
$store_locator_url    = selecta_get_nav_link_url( 'internal', $store_locator_path, '' );
$has_primary_menu  = has_nav_menu( 'primary' );
$bar_class         = 'site-header__bar';

if ( $logo_id ) {
	$bar_class .= ' site-header__bar--has-logo';
}
?>
<div class="<?php echo esc_attr( $bar_class ); ?>">
	<div class="container site-header__inner">
		<button
			type="button"
			class="site-header__burger"
			aria-label="<?php esc_attr_e( 'Open menu', 'selecta-theme' ); ?>"
			aria-expanded="false"
			aria-controls="mobile-menu"
		>
			<?php echo selecta_get_svg( 'hamburger' ); ?>
		</button>

		<div class="site-header__brand">
			<a class="site-header__logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( $logo_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						(int) $logo_id,
						'medium',
						false,
						array(
							'class' => 'site-header__logo-image',
							'alt'   => get_bloginfo( 'name' ),
						)
					);
					?>
				<?php else : ?>
					<span class="site-header__logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				<?php endif; ?>
			</a>
		</div>

		<?php if ( $has_primary_menu ) : ?>
			<nav class="site-header__nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'selecta-theme' ); ?>">
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

		<div class="site-header__actions">
			<button
				type="button"
				class="site-header__action site-header__action--search"
				aria-label="<?php esc_attr_e( 'Search', 'selecta-theme' ); ?>"
			>
				<span class="site-header__action-icon site-header__action-icon--search">
					<?php echo selecta_get_svg( 'search' ); ?>
				</span>
			</button>

			<?php if ( $store_locator_url ) : ?>
				<a
					class="site-header__action site-header__action--store"
					href="<?php echo esc_url( $store_locator_url ); ?>"
				>
					<span class="site-header__action-icon site-header__action-icon--store">
						<?php echo selecta_get_svg( 'store-locator' ); ?>
					</span>
					<span class="screen-reader-text"><?php esc_html_e( 'Store locator', 'selecta-theme' ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
