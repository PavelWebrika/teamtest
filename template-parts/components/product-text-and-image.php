<?php
/**
 * Product text and image section.
 *
 * Two-column layout with configurable text/image order on desktop.
 * Mobile stack mirrors desktop horizontal order: left → top, right → bottom.
 *
 * Reads sub_fields from the active product_sections flexible content row.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'selecta-product-text-and-image' );

$heading        = (string) selecta_get_sub_field( 'section_heading' );
$body_text      = (string) selecta_get_sub_field( 'body_text' );
$image_id       = (int) selecta_get_sub_field( 'image' );
$image_position = (string) selecta_get_sub_field( 'image_position', 'text_left' );

if ( ! $heading && ! $body_text && ! $image_id ) {
	return;
}

$section_classes = 'product-text-and-image';

if ( 'image_left' === $image_position ) {
	$section_classes .= ' product-text-and-image--image-left';
}
?>

<section class="<?php echo esc_attr( $section_classes ); ?>">
	<div class="container product-text-and-image__inner">

		<div class="product-text-and-image__text">

			<?php if ( $heading ) : ?>
				<div class="product-text-and-image__heading-wrap">
					<h2 class="product-text-and-image__heading"><?php echo esc_html( $heading ); ?></h2>
					<span class="product-text-and-image__heading-bar" aria-hidden="true"></span>
				</div>
			<?php endif; ?>

			<?php if ( $body_text ) : ?>
				<div class="product-text-and-image__body">
					<?php echo wp_kses_post( $body_text ); ?>
				</div>
			<?php endif; ?>

		</div>

		<?php if ( $image_id ) : ?>
			<div class="product-text-and-image__image-wrap">
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					array( 'class' => 'product-text-and-image__image' )
				);
				?>
			</div>
		<?php endif; ?>

	</div>
</section>
