<?php
/**
 * Product grid progress indicator.
 *
 * Shows how many products are visible out of the total in the current query.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_query;

$total = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;

if ( $total <= 0 ) {
	return;
}

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$per_page = isset( $wp_query->query_vars['posts_per_page'] ) ? (int) $wp_query->query_vars['posts_per_page'] : 0;

if ( $per_page <= 0 ) {
	$per_page = (int) get_option( 'posts_per_page' );
}

$seen    = min( ( ( $paged - 1 ) * $per_page ) + (int) $wp_query->post_count, $total );
$percent = $total > 0 ? min( 100, ( $seen / $total ) * 100 ) : 0;

wp_enqueue_style( 'selecta-product-grid-progress' );
wp_print_styles( 'selecta-product-grid-progress' );
?>

<div
	class="product-grid-progress"
	role="status"
	aria-live="polite"
	aria-label="<?php echo esc_attr( sprintf( 'Seen %1$d products out of %2$d', $seen, $total ) ); ?>"
>
	<p class="product-grid-progress__text">
		<?php
		printf(
			esc_html__( 'Видяхте %1$d продукта от %2$d', 'selecta-theme' ),
			(int) $seen,
			(int) $total
		);
		?>
	</p>

	<div
		class="product-grid-progress__bar"
		role="progressbar"
		aria-valuemin="0"
		aria-valuemax="<?php echo esc_attr( (string) $total ); ?>"
		aria-valuenow="<?php echo esc_attr( (string) $seen ); ?>"
	>
		<span class="product-grid-progress__fill" style="width: <?php echo esc_attr( (string) $percent ); ?>%;"></span>
	</div>
</div>
