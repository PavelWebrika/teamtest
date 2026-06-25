<?php
/**
 * Hero banner section.
 *
 * Reads its own sub_fields from the active flexible content row.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'selecta-hero-banner' );
wp_print_styles( 'selecta-hero-banner' );

$bg_image_id  = (int) selecta_get_sub_field( 'bg_image' );
$bg_video_url = (string) selecta_get_sub_field( 'bg_video' );
$heading      = (string) selecta_get_sub_field( 'heading' );
$subheading   = (string) selecta_get_sub_field( 'subheading' );

if ( ! $bg_image_id && ! $bg_video_url && ! $heading && ! $subheading ) {
	return;
}
?>

<section class="hero-banner">

	<?php if ( $bg_video_url || $bg_image_id ) : ?>
		<div class="hero-banner__bg" aria-hidden="true">
			<?php if ( $bg_video_url ) : ?>
				<video
					class="hero-banner__bg-video"
					autoplay
					muted
					loop
					playsinline
					<?php if ( $bg_image_id ) : ?>
						poster="<?php echo esc_url( wp_get_attachment_image_url( $bg_image_id, 'full' ) ); ?>"
					<?php endif; ?>
				>
					<source src="<?php echo esc_url( $bg_video_url ); ?>" type="video/mp4">
				</video>
			<?php elseif ( $bg_image_id ) : ?>
				<?php
				echo wp_get_attachment_image(
					$bg_image_id,
					'full',
					false,
					array( 'class' => 'hero-banner__bg-img' )
				);
				?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( $heading || $subheading ) : ?>
		<div class="hero-banner__content">
			<?php if ( $heading ) : ?>
				<h1 class="hero-banner__heading"><?php echo esc_html( $heading ); ?></h1>
			<?php endif; ?>
			<?php if ( $subheading ) : ?>
				<p class="hero-banner__subheading"><?php echo esc_html( $subheading ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

</section>
