<?php
/**
 * ACF admin-only assets and UI helpers.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_enqueue_scripts', 'selecta_enqueue_acf_admin_assets' );
function selecta_enqueue_acf_admin_assets( $hook_suffix ) {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( $screen && false !== strpos( (string) $screen->id, 'selecta-nav-panels' ) ) {
		selecta_enqueue_admin_asset(
			'selecta-admin-nav-panels-css',
			'assets/css/admin/nav-panels.css'
		);

		selecta_enqueue_admin_asset(
			'selecta-admin-nav-panels-js',
			'assets/js/admin/nav-panels.js',
			true,
			array( 'jquery', 'acf-input' )
		);
	}

	if ( 'nav-menus.php' === $hook_suffix ) {
		selecta_enqueue_admin_asset(
			'selecta-admin-nav-menus-css',
			'assets/css/admin/nav-menus.css'
		);

		selecta_enqueue_admin_asset(
			'selecta-admin-nav-menus-js',
			'assets/js/admin/nav-menus-hint.js',
			true
		);
	}
}

/**
 * Enqueue a theme admin CSS or JS file with filemtime versioning.
 *
 * @param string       $handle   Asset handle prefix.
 * @param string       $path     Path relative to theme root.
 * @param bool         $is_script Whether the asset is JavaScript.
 * @param string|array $deps     Script/style dependencies.
 */
function selecta_enqueue_admin_asset( $handle, $path, $is_script = false, $deps = array() ) {
	$full_path = get_template_directory() . '/' . $path;
	$full_uri  = get_template_directory_uri() . '/' . $path;
	$version   = file_exists( $full_path ) ? filemtime( $full_path ) : wp_get_theme()->get( 'Version' );

	if ( $is_script ) {
		wp_enqueue_script( $handle, $full_uri, $deps, $version, true );
		return;
	}

	wp_enqueue_style( $handle, $full_uri, $deps, $version );
}
