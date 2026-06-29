<?php
/**
 * Category archive banner.
 *
 * @package SelectaTheme
 *
 * @var array $args {
 *     @type WP_Term|null $term Queried category term.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'selecta-category-banner' );
wp_print_styles( 'selecta-category-banner' );

$term = isset( $args['term'] ) && $args['term'] instanceof WP_Term ? $args['term'] : get_queried_object();

if ( ! $term instanceof WP_Term ) {
	return;
}

$banner_image_id = (int) selecta_get_field(
	'category_banner_image',
	$term->taxonomy . '_' . $term->term_id
);
?>

<section class="category-banner<?php echo $banner_image_id ? ' category-banner--has-image' : ''; ?>">
	<?php if ( $banner_image_id ) : ?>
		<div class="category-banner__media" aria-hidden="true">
			<?php
			echo wp_get_attachment_image(
				$banner_image_id,
				'full',
				false,
				array( 'class' => 'category-banner__bg-img' )
			);
			?>
		</div>
	<?php endif; ?>

	<div class="category-banner__content">
		<h1 class="category-banner__title"><?php echo esc_html( $term->name ); ?></h1>
	</div>
</section>
