<?php
/**
 * Theme helper functions.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Safely get an ACF field value with a fallback default.
 *
 * Returns $default when ACF is inactive, the field is empty, or the value is null/false.
 *
 * @param string     $selector  Field name or key.
 * @param int|string $post_id   Post ID, option name, or false for current post.
 * @param mixed      $default   Value to return when field is empty.
 * @return mixed
 */
function selecta_get_field( $selector, $post_id = false, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $selector, $post_id );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Safely get an ACF sub_field value with a fallback default.
 *
 * For use inside have_rows() / flexible content loops.
 *
 * @param string $selector Field name or key.
 * @param mixed  $default  Value to return when field is empty.
 * @return mixed
 */
function selecta_get_sub_field( $selector, $default = '' ) {
	if ( ! function_exists( 'get_sub_field' ) ) {
		return $default;
	}

	$value = get_sub_field( $selector );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Load an SVG markup string from assets/svgs/{name}.php.
 *
 * Each file in assets/svgs/ must return an SVG string.
 *
 * @param string $name SVG file name without extension, e.g. 'star'.
 * @return string SVG markup or empty string if not found.
 */
function selecta_get_svg( $name ) {
	$name = sanitize_file_name( $name );

	if ( '' === $name ) {
		return '';
	}

	$path = get_template_directory() . '/assets/svgs/' . $name . '.php';

	if ( ! file_exists( $path ) ) {
		return '';
	}

	$svg = include $path;

	return is_string( $svg ) ? $svg : '';
}

/**
 * Build a nav panel link URL from ACF link type fields.
 *
 * @param string $link_type  internal|external, or empty for legacy rows.
 * @param string $link_path  Site path when internal.
 * @param string $link_url   Full URL when external (legacy rows may only have this).
 * @return string
 */
function selecta_get_nav_link_url( $link_type, $link_path, $link_url ) {
	$link_path = trim( (string) $link_path );
	$link_url  = trim( (string) $link_url );

	if ( '' === $link_type || false === $link_type || null === $link_type ) {
		if ( '' !== $link_path ) {
			$link_type = 'internal';
		} elseif ( '' !== $link_url ) {
			return $link_url;
		} else {
			return '';
		}
	}

	if ( 'internal' === $link_type ) {
		if ( '' === $link_path ) {
			return '';
		}

		if ( '/' === $link_path ) {
			return home_url( '/' );
		}

		if ( 0 === strpos( $link_path, '/' ) ) {
			return home_url( $link_path );
		}

		return home_url( '/' . $link_path );
	}

	return $link_url;
}
