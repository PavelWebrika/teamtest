<?php
/**
 * Asset loading.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function selecta_enqueue_assets() {
	$css_path = get_template_directory() . '/assets/css/main.css';
	$css_uri  = get_template_directory_uri() . '/assets/css/main.css';

	wp_enqueue_style(
		'selecta-main',
		$css_uri,
		array(),
		file_exists( $css_path ) ? filemtime( $css_path ) : wp_get_theme()->get( 'Version' )
	);

	$js_path = get_template_directory() . '/assets/js/main.js';
	$js_uri  = get_template_directory_uri() . '/assets/js/main.js';

	wp_enqueue_script(
		'selecta-main',
		$js_uri,
		array(),
		file_exists( $js_path ) ? filemtime( $js_path ) : wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'selecta_enqueue_assets' );
