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

		<?php if ( function_exists( 'have_rows' ) && have_rows( 'nav_panels', 'option' ) ) : ?>
			<?php while ( have_rows( 'nav_panels', 'option' ) ) : the_row(); ?>
				<?php
				$panel_key  = get_sub_field( 'panel_key' );
				$panel_type = get_sub_field( 'panel_type' );

				if ( ! $panel_key ) {
					continue;
				}
				?>
				<div
					class="mobile-nav-panel mobile-nav-panel--<?php echo esc_attr( $panel_type ); ?>"
					data-panel="<?php echo esc_attr( $panel_key ); ?>"
					hidden
				>
					<?php if ( 'simple' === $panel_type && have_rows( 'featured_items' ) ) : ?>

						<ul class="mobile-nav-panel__simple">
							<?php while ( have_rows( 'featured_items' ) ) : the_row(); ?>
								<?php
								$title     = get_sub_field( 'item_title' );
								$link_type = get_sub_field( 'item_link_type' );
								$link_path = get_sub_field( 'item_link_path' );
								$link_url  = get_sub_field( 'item_url' );
								$url       = selecta_get_nav_link_url( $link_type, $link_path, $link_url );

								if ( ! $title || ! $url ) {
									continue;
								}
								?>
								<li class="mobile-nav-panel__simple-item">
									<a class="mobile-nav-panel__simple-link" href="<?php echo esc_url( $url ); ?>">
										<?php echo wp_kses_post( $title ); ?>
									</a>
								</li>
							<?php endwhile; ?>
						</ul>

					<?php elseif ( 'mega' === $panel_type && have_rows( 'mega_columns' ) ) : ?>

						<div class="mobile-nav-panel__mega">
							<?php while ( have_rows( 'mega_columns' ) ) : the_row(); ?>
								<?php $col_title = get_sub_field( 'column_title' ); ?>
								<?php if ( ! have_rows( 'column_links' ) ) : continue; endif; ?>
								<div class="mobile-nav-panel__column is-expanded">
									<?php if ( $col_title ) : ?>
										<button
											type="button"
											class="mobile-nav-panel__column-toggle"
											aria-expanded="true"
										>
											<span><?php echo esc_html( $col_title ); ?></span>
											<span class="mobile-nav-panel__column-chevron" aria-hidden="true"></span>
										</button>
									<?php endif; ?>
									<ul class="mobile-nav-panel__column-links">
										<?php while ( have_rows( 'column_links' ) ) : the_row(); ?>
											<?php
											$link_text = get_sub_field( 'link_text' );
											$link_type = get_sub_field( 'link_type' );
											$link_path = get_sub_field( 'link_path' );
											$link_url  = get_sub_field( 'link_url' );
											$url       = selecta_get_nav_link_url( $link_type, $link_path, $link_url );

											if ( ! $link_text || ! $url ) {
												continue;
											}
											?>
											<li>
												<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $link_text ); ?></a>
											</li>
										<?php endwhile; ?>
									</ul>
								</div>
							<?php endwhile; ?>
						</div>

					<?php endif; ?>
				</div>
			<?php endwhile; ?>
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
