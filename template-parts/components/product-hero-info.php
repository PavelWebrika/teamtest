<?php
/**
 * Product hero — right column info panel.
 *
 * Reads from:
 *   - get_the_title()         → product name (display title)
 *   - selecta_product_line    → product line (purple heading)
 *   - get_sub_field('product_hero_description') → hero description (wysiwyg)
 *   - get_field('product_short_benefits')   → concern/hair-type line (group_product_card_meta)
 *   - get_field('product_score')            → star rating (group_product_card_meta)
 *   - get_sub_field(...)      → tag, hero description, format, review count, vegan note, variants
 *
 * Called from product-gallery.php while a flexible content row is active.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

$product_name     = get_the_title();
$short_benefits   = function_exists( 'get_field' ) ? (string) get_field( 'product_short_benefits' ) : '';
$score            = function_exists( 'get_field' ) ? get_field( 'product_score' ) : null;
$hero_description = function_exists( 'get_sub_field' ) ? (string) get_sub_field( 'product_hero_description' ) : '';

$post_id      = get_the_ID();
$line_terms   = $post_id ? wp_get_object_terms( $post_id, 'selecta_product_line', array( 'fields' => 'names' ) ) : array();
$product_line = ( ! is_wp_error( $line_terms ) && ! empty( $line_terms ) ) ? $line_terms[0] : '';

$tag             = function_exists( 'get_sub_field' ) ? (string) get_sub_field( 'product_tag' ) : '';
$format          = function_exists( 'get_sub_field' ) ? (string) get_sub_field( 'product_format' ) : '';
$review_count    = function_exists( 'get_sub_field' ) ? get_sub_field( 'product_review_count' ) : null;
$vegan_note      = function_exists( 'get_sub_field' ) ? (string) get_sub_field( 'product_vegan_note' ) : '';
$variants        = function_exists( 'get_sub_field' ) ? get_sub_field( 'product_variants' ) : array();

$has_rating      = is_numeric( $score ) && $score > 0;
$has_variants    = ! empty( $variants ) && is_array( $variants );
?>

<div class="product-hero-info">

	<?php if ( $short_benefits ) : ?>
		<p class="product-hero-info__benefits"><?php echo esc_html( $short_benefits ); ?></p>
	<?php endif; ?>

	<div class="product-hero-info__title-group">

		<?php if ( $product_line ) : ?>
			<p class="product-hero-info__line"><?php echo esc_html( $product_line ); ?></p>
		<?php endif; ?>

		<?php if ( $product_name ) : ?>
			<h1 class="product-hero-info__name"><?php echo esc_html( $product_name ); ?></h1>
		<?php endif; ?>

	</div>

	<?php if ( $tag ) : ?>
		<span class="product-hero-info__tag"><?php echo esc_html( $tag ); ?></span>
	<?php endif; ?>

	<?php if ( $hero_description ) : ?>
		<div class="product-hero-info__description">
			<?php echo wp_kses_post( $hero_description ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $format ) : ?>
		<p class="product-hero-info__format"><?php echo esc_html( $format ); ?></p>
	<?php endif; ?>

	<?php if ( $has_rating ) : ?>
		<div class="product-hero-info__rating">
			<?php
			$score_clamped = min( 5, max( 0, (float) $score ) );
			$full_stars    = (int) floor( $score_clamped );
			$has_half      = ( $score_clamped - $full_stars ) >= 0.5;
			$empty_stars   = 5 - $full_stars - ( $has_half ? 1 : 0 );
			$star_svg      = selecta_get_svg( 'star' );
			?>
			<span class="product-hero-info__stars" aria-label="<?php echo esc_attr( $score_clamped . ' / 5' ); ?>">
				<?php
				for ( $i = 0; $i < $full_stars; $i++ ) {
					echo '<span class="product-hero-info__star product-hero-info__star--full">' . $star_svg . '</span>';
				}
				if ( $has_half ) {
					echo '<span class="product-hero-info__star product-hero-info__star--half">' . $star_svg . '</span>';
				}
				for ( $i = 0; $i < $empty_stars; $i++ ) {
					echo '<span class="product-hero-info__star product-hero-info__star--empty">' . $star_svg . '</span>';
				}
				?>
			</span>

			<?php if ( $review_count ) : ?>
				<span class="product-hero-info__review-count">
					<?php echo esc_html( number_format_i18n( (int) $review_count ) . ' ' . __( 'Отзива', 'selecta-theme' ) ); ?>
				</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( $vegan_note ) : ?>
		<p class="product-hero-info__vegan-note"><?php echo esc_html( $vegan_note ); ?></p>
	<?php endif; ?>

	<?php if ( $has_variants ) : ?>
		<ul class="product-hero-info__variants" aria-label="<?php esc_attr_e( 'Налични варианти', 'selecta-theme' ); ?>">
			<?php foreach ( $variants as $variant ) :
				$v_image_id = ! empty( $variant['variant_image'] ) ? (int) $variant['variant_image'] : 0;
				$v_label    = ! empty( $variant['variant_label'] ) ? (string) $variant['variant_label'] : '';

				if ( ! $v_image_id && ! $v_label ) {
					continue;
				}
			?>
				<li class="product-hero-info__variant">
					<?php if ( $v_image_id ) : ?>
						<span class="product-hero-info__variant-img-wrap">
							<?php echo wp_get_attachment_image( $v_image_id, 'thumbnail', false, array( 'class' => 'product-hero-info__variant-img' ) ); ?>
						</span>
					<?php endif; ?>
					<?php if ( $v_label ) : ?>
						<span class="product-hero-info__variant-label"><?php echo esc_html( $v_label ); ?></span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

</div>
