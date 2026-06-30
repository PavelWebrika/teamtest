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

	wp_localize_script(
		'selecta-main',
		'selectaSearch',
		array(
			'restUrl'    => esc_url_raw( rest_url( 'selecta/v1/search' ) ),
			'minChars'   => 3,
			'debounceMs' => 250,
		)
	);

	$search_js_path = get_template_directory() . '/assets/js/search.js';
	$search_js_uri  = get_template_directory_uri() . '/assets/js/search.js';

	wp_enqueue_script(
		'selecta-search',
		$search_js_uri,
		array( 'selecta-main' ),
		file_exists( $search_js_path ) ? filemtime( $search_js_path ) : wp_get_theme()->get( 'Version' ),
		true
	);

	selecta_register_swiper_assets();
	selecta_register_component_styles();
	selecta_enqueue_admin_bar_styles();
}
add_action( 'wp_enqueue_scripts', 'selecta_enqueue_assets' );

function selecta_register_swiper_assets() {
	$swiper_css_path = get_template_directory() . '/node_modules/swiper/swiper-bundle.min.css';
	$swiper_css_uri  = get_template_directory_uri() . '/node_modules/swiper/swiper-bundle.min.css';
	$swiper_js_path  = get_template_directory() . '/node_modules/swiper/swiper-bundle.min.js';
	$swiper_js_uri   = get_template_directory_uri() . '/node_modules/swiper/swiper-bundle.min.js';

	if ( ! file_exists( $swiper_css_path ) || ! file_exists( $swiper_js_path ) ) {
		return;
	}

	$version = filemtime( $swiper_js_path );

	wp_register_style(
		'selecta-swiper',
		$swiper_css_uri,
		array(),
		$version
	);

	wp_register_script(
		'selecta-swiper',
		$swiper_js_uri,
		array(),
		$version,
		true
	);
}

function selecta_enqueue_swiper_assets() {
	selecta_register_swiper_assets();

	wp_enqueue_style( 'selecta-swiper' );
	wp_enqueue_script( 'selecta-swiper' );
}

function selecta_enqueue_admin_bar_styles() {
	if ( ! is_admin_bar_showing() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/admin-bar.css';
	$css_uri  = get_template_directory_uri() . '/assets/css/components/admin-bar.css';

	wp_enqueue_style(
		'selecta-admin-bar',
		$css_uri,
		array( 'admin-bar' ),
		file_exists( $css_path ) ? filemtime( $css_path ) : wp_get_theme()->get( 'Version' )
	);
}

function selecta_register_component_styles() {
	$components = array(
		'selecta-site-header'           => 'assets/css/components/site-header.css',
		'selecta-mobile-menu'           => 'assets/css/components/mobile-menu.css',
		'selecta-search-overlay'        => 'assets/css/components/search-overlay.css',
		'selecta-hero-banner'           => 'assets/css/components/hero-banner.css',
		'selecta-text-block'            => 'assets/css/components/text-block.css',
		'selecta-product-description'   => 'assets/css/components/product-description.css',
		'selecta-product-card'          => 'assets/css/components/product-card.css',
		'selecta-category-banner'       => 'assets/css/components/category-banner.css',
		'selecta-category-intro'        => 'assets/css/components/category-intro.css',
		'selecta-product-grid-progress' => 'assets/css/components/product-grid-progress.css',
	);

	foreach ( $components as $handle => $path ) {
		$full_path = get_template_directory() . '/' . $path;
		$full_uri  = get_template_directory_uri() . '/' . $path;

		wp_register_style(
			$handle,
			$full_uri,
			array( 'selecta-main' ),
			file_exists( $full_path ) ? filemtime( $full_path ) : wp_get_theme()->get( 'Version' )
		);
	}
}
