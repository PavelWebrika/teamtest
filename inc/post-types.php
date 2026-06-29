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
				'name'          => esc_html__( 'Product Categories', 'selecta-theme' ),
				'singular_name' => esc_html__( 'Product Category', 'selecta-theme' ),
				'all_items'     => esc_html__( 'All Categories', 'selecta-theme' ),
				'edit_item'     => esc_html__( 'Edit Category', 'selecta-theme' ),
				'add_new_item'  => esc_html__( 'Add New Category', 'selecta-theme' ),
				'search_items'  => esc_html__( 'Search Categories', 'selecta-theme' ),
				'menu_name'     => esc_html__( 'Categories', 'selecta-theme' ),
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
				'name'          => esc_html__( 'Product Lines', 'selecta-theme' ),
				'singular_name' => esc_html__( 'Product Line', 'selecta-theme' ),
				'all_items'     => esc_html__( 'All Product Lines', 'selecta-theme' ),
				'edit_item'     => esc_html__( 'Edit Product Line', 'selecta-theme' ),
				'add_new_item'  => esc_html__( 'Add New Product Line', 'selecta-theme' ),
				'search_items'  => esc_html__( 'Search Product Lines', 'selecta-theme' ),
				'menu_name'     => esc_html__( 'Product Lines', 'selecta-theme' ),
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
				'name'          => esc_html__( 'Hair Types', 'selecta-theme' ),
				'singular_name' => esc_html__( 'Hair Type', 'selecta-theme' ),
				'all_items'     => esc_html__( 'All Hair Types', 'selecta-theme' ),
				'edit_item'     => esc_html__( 'Edit Hair Type', 'selecta-theme' ),
				'add_new_item'  => esc_html__( 'Add New Hair Type', 'selecta-theme' ),
				'search_items'  => esc_html__( 'Search Hair Types', 'selecta-theme' ),
				'menu_name'     => esc_html__( 'Hair Types', 'selecta-theme' ),
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
				'name'          => esc_html__( 'Hair Concerns', 'selecta-theme' ),
				'singular_name' => esc_html__( 'Hair Concern', 'selecta-theme' ),
				'all_items'     => esc_html__( 'All Hair Concerns', 'selecta-theme' ),
				'edit_item'     => esc_html__( 'Edit Hair Concern', 'selecta-theme' ),
				'add_new_item'  => esc_html__( 'Add New Hair Concern', 'selecta-theme' ),
				'search_items'  => esc_html__( 'Search Hair Concerns', 'selecta-theme' ),
				'menu_name'     => esc_html__( 'Hair Concerns', 'selecta-theme' ),
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
				'name'               => esc_html__( 'Products', 'selecta-theme' ),
				'singular_name'      => esc_html__( 'Product', 'selecta-theme' ),
				'add_new_item'       => esc_html__( 'Add New Product', 'selecta-theme' ),
				'edit_item'          => esc_html__( 'Edit Product', 'selecta-theme' ),
				'new_item'           => esc_html__( 'New Product', 'selecta-theme' ),
				'view_item'          => esc_html__( 'View Product', 'selecta-theme' ),
				'search_items'       => esc_html__( 'Search Products', 'selecta-theme' ),
				'not_found'          => esc_html__( 'No products found', 'selecta-theme' ),
				'not_found_in_trash' => esc_html__( 'No products found in trash', 'selecta-theme' ),
				'menu_name'          => esc_html__( 'Products', 'selecta-theme' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'has_archive'        => true,
			'menu_icon'          => 'dashicons-products',
			'menu_position'      => 20,
			'show_in_rest'       => true,
			'rewrite'            => array( 'slug' => 'products' ),
			'supports'           => array( 'title', 'thumbnail', 'revisions' ),
			'taxonomies'         => array( 'selecta_product_category', 'selecta_product_line', 'selecta_hair_type', 'selecta_hair_concern' ),
		)
	);
}
add_action( 'init', 'selecta_register_content_types' );
