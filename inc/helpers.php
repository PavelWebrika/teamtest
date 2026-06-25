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
