<?php
/**
 * Flexible content layout dispatcher.
 *
 * Loops through the page_sections flexible content field and
 * routes each layout to its matching template part.
 *
 * @package SelectaTheme
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'have_rows' ) ) {
	return;
}

if ( ! have_rows( 'page_sections' ) ) {
	return;
}

while ( have_rows( 'page_sections' ) ) :
	the_row();

	$layout = get_row_layout();

	switch ( $layout ) {
		case 'hero_banner':
			get_template_part( 'template-parts/components/hero-banner' );
			break;

		case 'text_block':
			get_template_part( 'template-parts/components/text-block' );
			break;

		default:
			break;
	}

endwhile;
