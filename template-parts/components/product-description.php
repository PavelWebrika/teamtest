<?php
/**
 * Product description section.
 *
 * Two-column layout: rich text left, image right (desktop).
 * Single column stacked on mobile.
 *
 * Reads sub_fields from the active product_sections flexible content row.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'selecta-product-description' );

$heading   = (string) selecta_get_sub_field( 'section_heading', 'Описание' );
$body_text = (string) selecta_get_sub_field( 'body_text' );
$image_id  = (int) selecta_get_sub_field( 'image' );

if ( ! $heading && ! $body_text && ! $image_id ) {
	return;
}
?>

<section class="product-description">
	<div class="container product-description__inner">

		<div class="product-description__text">

			<?php if ( $heading ) : ?>
				<div class="product-description__heading-wrap">
					<h2 class="product-description__heading"><?php echo esc_html( $heading ); ?></h2>
					<span class="product-description__heading-bar" aria-hidden="true"></span>
				</div>
			<?php endif; ?>

			<?php if ( $body_text ) : ?>
				<div class="product-description__body">
					<?php echo wp_kses_post( $body_text ); ?>
				</div>
			<?php endif; ?>

		</div>

		<?php if ( $image_id ) : ?>
			<div class="product-description__image-wrap">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					array( 'class' => 'product-description__image' )
				);
				?>
			</div>
		<?php endif; ?>

	</div>
</section>
