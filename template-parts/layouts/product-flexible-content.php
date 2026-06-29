<?php
/**
 * Product flexible content layout dispatcher.
 *
 * Loops through the product_sections flexible content field and
 * routes each layout to its matching template part.
 *
 * New product section layouts are registered here as they are
 * built from Figma components.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'have_rows' ) ) {
	return;
}

if ( ! have_rows( 'product_sections' ) ) {
	return;
}

while ( have_rows( 'product_sections' ) ) :
	the_row();

	$layout = get_row_layout();

	switch ( $layout ) {

		case 'product_description':
			get_template_part( 'template-parts/components/product-description' );
			break;

		default:
			break;
	}

endwhile;
