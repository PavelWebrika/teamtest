<?php
/**
 * Product card component.
 *
 * Used in archive-selecta_product.php and any product grid loop.
 * Must be called inside a WP_Query or have_posts() loop so the
 * global post is set. Accepts no $args — reads directly from the
 * current post in the loop.
 *
 * Every field is optional. The card renders with whatever is available
 * and skips missing pieces silently.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

if ( ! $post_id ) {
	return;
}

$title       = get_the_title();
$permalink   = get_the_permalink();
$badge       = selecta_get_field( 'product_badge', $post_id );
$benefits    = function_exists( 'get_field' ) ? get_field( 'product_short_benefits', $post_id, false, false ) : '';
$benefits    = is_string( $benefits ) ? trim( $benefits ) : '';
$benefit_lines = array();

if ( '' !== $benefits ) {
	$benefit_lines = array_filter(
		array_map( 'trim', preg_split( '/\r\n|\r|\n/', $benefits ) )
	);
}
$score_raw   = selecta_get_field( 'product_score', $post_id );
$price       = selecta_get_field( 'product_price', $post_id );

$score       = ( '' !== $score_raw && is_numeric( $score_raw ) ) ? (float) $score_raw : null;

$lines       = wp_get_object_terms( $post_id, 'selecta_product_line', array( 'fields' => 'names' ) );
$product_line = ( ! is_wp_error( $lines ) && ! empty( $lines ) ) ? $lines[0] : '';
?>

<article class="product-card">

	<a class="product-card__image-link" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
		<div class="product-card__image-wrap">

			<?php if ( $badge ) : ?>
				<span class="product-card__badge"><?php echo esc_html( $badge ); ?></span>
			<?php endif; ?>

			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<?php
				the_post_thumbnail(
					'medium_large',
					array(
						'class' => 'product-card__image',
						'alt'   => esc_attr( $title ),
					)
				);
				?>
			<?php else : ?>
				<div class="product-card__image-placeholder" aria-hidden="true"></div>
			<?php endif; ?>

		</div>
	</a>

	<div class="product-card__body">

		<div class="product-card__info">

			<?php if ( $title ) : ?>
				<a class="product-card__title-link" href="<?php echo esc_url( $permalink ); ?>">
					<h2 class="product-card__title"><?php echo esc_html( $title ); ?></h2>
				</a>
			<?php endif; ?>

			<?php if ( $product_line ) : ?>
				<span class="product-card__line"><?php echo esc_html( $product_line ); ?></span>
			<?php endif; ?>

		</div>

		<?php if ( ! empty( $benefit_lines ) ) : ?>
			<div class="product-card__benefits">
				<?php foreach ( $benefit_lines as $benefit_line ) : ?>
					<span class="product-card__benefit-line"><?php echo esc_html( $benefit_line ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( null !== $score || $price ) : ?>
			<div class="product-card__review-price">

				<?php if ( null !== $score ) : ?>
					<?php
					$score_clamped = max( 0, min( 5, $score ) );
					$fill_pct      = round( ( $score_clamped / 5 ) * 100, 2 );
					$star_svg      = selecta_get_svg( 'star' );
					$five_stars    = str_repeat( $star_svg, 5 );
					?>
					<div class="product-card__stars-row">
						<div
							class="product-card__stars"
							role="img"
							aria-label="<?php echo esc_attr( sprintf( 'Score: %s out of 5', $score_clamped ) ); ?>"
						>
							<span class="product-card__stars-empty" aria-hidden="true"><?php
								// phpcs:ignore WordPress.Security.EscapeOutput -- hardcoded SVG file, no user input
								echo $five_stars;
							?></span>
							<span
								class="product-card__stars-filled"
								aria-hidden="true"
								style="width:<?php echo esc_attr( $fill_pct ); ?>%"
							><?php
								// phpcs:ignore WordPress.Security.EscapeOutput -- hardcoded SVG file, no user input
								echo $five_stars;
							?></span>
						</div>
						<span class="product-card__score" aria-hidden="true"><?php echo esc_html( $score_clamped ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( $price ) : ?>
					<span class="product-card__price"><?php echo esc_html( $price ); ?></span>
				<?php endif; ?>

			</div>
		<?php endif; ?>

	</div>

</article>
