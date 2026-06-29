<?php
/**
 * Header navigation panels.
 *
 * Renders dropdown/mega-menu panels driven by ACF Options.
 * Each panel is matched to a WP nav menu item via a CSS class
 * added in Appearance > Menus, e.g. "panel-key-complements".
 * Use the same full class as the Panel Key in Navigation admin.
 *
 * @package SelectaTheme
 */

if ( ! function_exists( 'have_rows' ) ) {
	return;
}

if ( ! have_rows( 'nav_panels', 'option' ) ) {
	return;
}
?>
<div class="nav-panels" aria-hidden="true">
	<?php while ( have_rows( 'nav_panels', 'option' ) ) : the_row(); ?>
		<?php
		$panel_key  = get_sub_field( 'panel_key' );
		$panel_type = get_sub_field( 'panel_type' );

		if ( ! $panel_key ) {
			continue;
		}
		?>
		<div
			class="nav-panel nav-panel--<?php echo esc_attr( $panel_type ); ?>"
			data-panel="<?php echo esc_attr( $panel_key ); ?>"
			hidden
		>
			<?php if ( 'simple' === $panel_type && have_rows( 'featured_items' ) ) : ?>

				<ul class="nav-panel__featured">
					<?php while ( have_rows( 'featured_items' ) ) : the_row(); ?>
						<?php
						$image_id = get_sub_field( 'item_image' );
						$title    = get_sub_field( 'item_title' );
						$url      = get_sub_field( 'item_url' );

						if ( ! $url ) {
							continue;
						}
						?>
						<li class="nav-panel__featured-item">
							<a class="nav-panel__featured-link" href="<?php echo esc_url( $url ); ?>">
								<span class="nav-panel__featured-media">
									<?php if ( $image_id ) : ?>
										<?php
										echo wp_get_attachment_image(
											(int) $image_id,
											'medium',
											false,
											array( 'class' => 'nav-panel__featured-image' )
										);
										?>
									<?php endif; ?>
								</span>
								<?php if ( $title ) : ?>
									<span class="nav-panel__featured-title"><?php echo wp_kses_post( $title ); ?></span>
								<?php endif; ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>

			<?php elseif ( 'mega' === $panel_type && have_rows( 'mega_columns' ) ) : ?>

				<div class="nav-panel__mega">
					<?php while ( have_rows( 'mega_columns' ) ) : the_row(); ?>
						<?php $col_title = get_sub_field( 'column_title' ); ?>
						<div class="nav-panel__mega-column">
							<?php if ( $col_title ) : ?>
								<p class="nav-panel__mega-column-title"><?php echo esc_html( $col_title ); ?></p>
							<?php endif; ?>
							<?php if ( have_rows( 'column_links' ) ) : ?>
								<ul class="nav-panel__mega-links">
									<?php while ( have_rows( 'column_links' ) ) : the_row(); ?>
										<?php
										$link_text = get_sub_field( 'link_text' );
										$link_url  = get_sub_field( 'link_url' );

										if ( ! $link_text || ! $link_url ) {
											continue;
										}
										?>
										<li>
											<a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_text ); ?></a>
										</li>
									<?php endwhile; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				</div>

			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</div>
