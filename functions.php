<?php
/**
 * Theme bootstrap.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$selecta_includes = array(
	'inc/setup.php',
	'inc/assets.php',
	'inc/post-types.php',
	'inc/acf.php',
	'inc/acf-admin.php',
	'inc/helpers.php',
);

foreach ( $selecta_includes as $selecta_file ) {
	$selecta_path = get_template_directory() . '/' . $selecta_file;
	if ( file_exists( $selecta_path ) ) {
		require_once $selecta_path;
	}
}
