<?php
/**
 * Text block section.
 *
 * Centered heading, tagline, and body text.
 * Reads its own sub_fields from the active flexible content row.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'selecta-text-block' );
wp_print_styles( 'selecta-text-block' );

$heading   = (string) selecta_get_sub_field( 'heading' );
$tagline   = (string) selecta_get_sub_field( 'tagline' );
$body_text = (string) selecta_get_sub_field( 'body_text' );

if ( ! $heading && ! $tagline && ! $body_text ) {
	return;
}
?>

<section class="text-block">
	<div class="container">

		<?php if ( $heading ) : ?>
			<h2 class="text-block__heading"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $tagline ) : ?>
			<p class="text-block__tagline"><?php echo esc_html( $tagline ); ?></p>
		<?php endif; ?>

		<?php if ( $body_text ) : ?>
			<div class="text-block__body"><?php echo wp_kses_post( $body_text ); ?></div>
		<?php endif; ?>

	</div>
</section>
