<?php
/**
 * Custom post types and taxonomies.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function selecta_register_content_types() {

	register_taxonomy(
		'selecta_product_category',
		array( 'selecta_product' ),
		array(
			'labels'            => array(
				'name'              => esc_html__( 'Категории продукти', 'selecta-theme' ),
				'singular_name'     => esc_html__( 'Категория продукт', 'selecta-theme' ),
				'all_items'         => esc_html__( 'Всички категории', 'selecta-theme' ),
				'edit_item'         => esc_html__( 'Редактирай категория', 'selecta-theme' ),
				'add_new_item'      => esc_html__( 'Добави категория', 'selecta-theme' ),
				'search_items'      => esc_html__( 'Търси категории', 'selecta-theme' ),
				'menu_name'         => esc_html__( 'Категории', 'selecta-theme' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'product-category' ),
		)
	);

	register_taxonomy(
		'selecta_product_line',
		array( 'selecta_product' ),
		array(
			'labels'            => array(
				'name'          => esc_html__( 'Серии', 'selecta-theme' ),
				'singular_name' => esc_html__( 'Серия', 'selecta-theme' ),
				'all_items'     => esc_html__( 'Всички серии', 'selecta-theme' ),
				'edit_item'     => esc_html__( 'Редактирай серия', 'selecta-theme' ),
				'add_new_item'  => esc_html__( 'Добави серия', 'selecta-theme' ),
				'search_items'  => esc_html__( 'Търси серии', 'selecta-theme' ),
				'menu_name'     => esc_html__( 'Серии', 'selecta-theme' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'product-line' ),
		)
	);

	register_taxonomy(
		'selecta_hair_type',
		array( 'selecta_product' ),
		array(
			'labels'            => array(
				'name'          => esc_html__( 'Тип коса', 'selecta-theme' ),
				'singular_name' => esc_html__( 'Тип коса', 'selecta-theme' ),
				'all_items'     => esc_html__( 'Всички типове коса', 'selecta-theme' ),
				'edit_item'     => esc_html__( 'Редактирай тип коса', 'selecta-theme' ),
				'add_new_item'  => esc_html__( 'Добави тип коса', 'selecta-theme' ),
				'search_items'  => esc_html__( 'Търси тип коса', 'selecta-theme' ),
				'menu_name'     => esc_html__( 'Тип коса', 'selecta-theme' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'hair-type' ),
		)
	);

	register_taxonomy(
		'selecta_hair_concern',
		array( 'selecta_product' ),
		array(
			'labels'            => array(
				'name'          => esc_html__( 'Проблем с косата', 'selecta-theme' ),
				'singular_name' => esc_html__( 'Проблем с косата', 'selecta-theme' ),
				'all_items'     => esc_html__( 'Всички проблеми', 'selecta-theme' ),
				'edit_item'     => esc_html__( 'Редактирай проблем', 'selecta-theme' ),
				'add_new_item'  => esc_html__( 'Добави проблем', 'selecta-theme' ),
				'search_items'  => esc_html__( 'Търси проблеми', 'selecta-theme' ),
				'menu_name'     => esc_html__( 'Проблеми', 'selecta-theme' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'hair-concern' ),
		)
	);

	register_post_type(
		'selecta_product',
		array(
			'labels'             => array(
				'name'               => esc_html__( 'Продукти', 'selecta-theme' ),
				'singular_name'      => esc_html__( 'Продукт', 'selecta-theme' ),
				'add_new_item'       => esc_html__( 'Добави продукт', 'selecta-theme' ),
				'edit_item'          => esc_html__( 'Редактирай продукт', 'selecta-theme' ),
				'new_item'           => esc_html__( 'Нов продукт', 'selecta-theme' ),
				'view_item'          => esc_html__( 'Виж продукт', 'selecta-theme' ),
				'search_items'       => esc_html__( 'Търси продукти', 'selecta-theme' ),
				'not_found'          => esc_html__( 'Няма намерени продукти', 'selecta-theme' ),
				'not_found_in_trash' => esc_html__( 'Няма продукти в кошчето', 'selecta-theme' ),
				'menu_name'          => esc_html__( 'Продукти', 'selecta-theme' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'has_archive'        => true,
			'menu_icon'          => 'dashicons-products',
			'menu_position'      => 20,
			'show_in_rest'       => true,
			'rewrite'            => array( 'slug' => 'products' ),
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
			'taxonomies'         => array( 'selecta_product_category', 'selecta_product_line', 'selecta_hair_type', 'selecta_hair_concern' ),
		)
	);
}
add_action( 'init', 'selecta_register_content_types' );
