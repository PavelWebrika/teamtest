<?php
/**
 * Category archive intro text.
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

$term = isset( $args['term'] ) && $args['term'] instanceof WP_Term ? $args['term'] : get_queried_object();

if ( ! $term instanceof WP_Term ) {
	return;
}

$intro_text = (string) selecta_get_field(
	'category_intro_text',
	$term->taxonomy . '_' . $term->term_id
);

if ( '' === trim( wp_strip_all_tags( $intro_text ) ) ) {
	return;
}

wp_enqueue_style( 'selecta-category-intro' );
wp_print_styles( 'selecta-category-intro' );
?>

<section class="category-intro">
	<div class="container">
		<div class="category-intro__content">
			<?php echo wp_kses_post( $intro_text ); ?>
		</div>
	</div>
</section>
