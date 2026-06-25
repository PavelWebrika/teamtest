<?php
/**
 * Theme setup.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function selecta_setup() {
	load_theme_textdomain( 'selecta-theme', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'selecta-theme' ),
			'footer'  => esc_html__( 'Footer Menu', 'selecta-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'selecta_setup' );
