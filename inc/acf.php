<?php
/**
 * ACF configuration and field groups.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'acf/settings/save_json', 'selecta_acf_json_save_path' );
function selecta_acf_json_save_path() {
	return get_template_directory() . '/acf-json';
}

add_filter( 'acf/settings/load_json', 'selecta_acf_json_load_paths' );
function selecta_acf_json_load_paths( $paths ) {
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}

add_action( 'acf/init', 'selecta_register_acf_field_groups' );

add_action( 'acf/init', 'selecta_register_nav_options_page' );
function selecta_register_nav_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => 'Navigation Panels',
			'menu_title' => 'Navigation',
			'menu_slug'  => 'selecta-nav-panels',
			'capability' => 'manage_options',
			'redirect'   => false,
		)
	);
}
function selecta_register_acf_field_groups() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key'    => 'group_page_flexible_sections',
		'title'  => 'Секции на страницата',
		'fields' => array(
			array(
				'key'          => 'field_page_sections',
				'label'        => 'Секции',
				'name'         => 'page_sections',
				'type'         => 'flexible_content',
				'button_label' => 'Добави секция',
				'layouts'      => array(
					'layout_text_block' => array(
					'key'        => 'layout_text_block',
					'name'       => 'text_block',
					'label'      => 'Text Block',
					'display'    => 'block',
					'sub_fields' => array(
						array(
							'key'          => 'field_text_block_heading',
							'label'        => 'Заглавие',
							'name'         => 'heading',
							'type'         => 'text',
							'instructions' => 'Незадължително.',
							'required'     => 0,
						),
						array(
							'key'          => 'field_text_block_tagline',
							'label'        => 'Подзаглавие / Tagline',
							'name'         => 'tagline',
							'type'         => 'text',
							'instructions' => 'Незадължително.',
							'required'     => 0,
						),
						array(
							'key'          => 'field_text_block_body',
							'label'        => 'Текст',
							'name'         => 'body_text',
							'type'         => 'wysiwyg',
							'instructions' => 'Незадължително.',
							'required'     => 0,
							'tabs'         => 'all',
							'toolbar'      => 'basic',
							'media_upload' => 0,
						),
					),
				),
				'layout_hero_banner' => array(
						'key'        => 'layout_hero_banner',
						'name'       => 'hero_banner',
						'label'      => 'Hero Banner',
						'display'    => 'block',
						'sub_fields' => array(
							array(
								'key'           => 'field_hero_banner_bg_image',
								'label'         => 'Фоново изображение',
								'name'          => 'bg_image',
								'type'          => 'image',
								'instructions'  => 'Незадължително.',
								'required'      => 0,
								'return_format' => 'id',
								'preview_size'  => 'medium',
								'library'       => 'all',
							),
							array(
								'key'          => 'field_hero_banner_heading',
								'label'        => 'Заглавие',
								'name'         => 'heading',
								'type'         => 'text',
								'instructions' => 'Незадължително.',
								'required'     => 0,
							),
						array(
							'key'          => 'field_hero_banner_subheading',
							'label'        => 'Подзаглавие',
							'name'         => 'subheading',
							'type'         => 'text',
							'instructions' => 'Незадължително.',
							'required'     => 0,
						),
						array(
							'key'           => 'field_hero_banner_bg_video',
							'label'         => 'Фоново видео',
							'name'          => 'bg_video',
							'type'          => 'file',
							'instructions'  => 'Незадължително. MP4 файл. Изображението се използва като постер/fallback.',
							'required'      => 0,
							'return_format' => 'url',
							'library'       => 'all',
							'mime_types'    => 'mp4',
						),
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				),
			),
		),
		'menu_order'      => 0,
		'position'        => 'acf_after_title',
		'style'           => 'default',
		'label_placement' => 'top',
	) );

	acf_add_local_field_group( array(
		'key'    => 'group_product_flexible_sections',
		'title'  => 'Product Sections',
		'fields' => array(
			array(
				'key'          => 'field_product_sections',
				'label'        => 'Sections',
				'name'         => 'product_sections',
				'type'         => 'flexible_content',
				'button_label' => 'Add Section',
				'layouts'      => array(
				'layout_product_description' => array(
					'key'        => 'layout_product_description',
					'name'       => 'product_description',
					'label'      => 'Description',
					'display'    => 'block',
					'sub_fields' => array(
						array(
							'key'           => 'field_pd_heading',
							'label'         => 'Section Heading',
							'name'          => 'section_heading',
							'type'          => 'text',
							'instructions'  => 'Default: Description',
							'required'      => 0,
							'default_value' => 'Description',
						),
						array(
							'key'          => 'field_pd_body',
							'label'        => 'Body Text',
							'name'         => 'body_text',
							'type'         => 'wysiwyg',
							'instructions' => 'Main product description. Supports bold text.',
							'required'      => 0,
							'tabs'          => 'all',
							'toolbar'       => 'basic',
							'media_upload'  => 0,
						),
						array(
							'key'           => 'field_pd_image',
							'label'         => 'Image',
							'name'          => 'image',
							'type'          => 'image',
							'instructions'  => 'Shown to the right of the text on desktop, below text on mobile.',
							'required'      => 0,
							'return_format' => 'id',
							'preview_size'  => 'medium',
							'library'       => 'all',
						),
					),
				),
			),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'selecta_product',
				),
			),
		),
		'menu_order'      => 0,
		'position'        => 'acf_after_title',
		'style'           => 'default',
		'label_placement' => 'top',
	) );

	acf_add_local_field_group( array(
		'key'    => 'group_product_card_meta',
		'title'  => 'Product Card',
		'fields' => array(
			array(
				'key'          => 'field_product_badge',
				'label'        => 'Badge',
				'name'         => 'product_badge',
				'type'         => 'text',
				'instructions' => 'Optional. e.g. "Best Seller", "New". Leave blank to hide.',
				'required'     => 0,
			),
			array(
				'key'           => 'field_product_hover_image',
				'label'         => 'Hover Image',
				'name'          => 'product_hover_image',
				'type'          => 'image',
				'instructions'  => 'Optional. Shown in place of the featured image when the card is hovered in product listings.',
				'required'      => 0,
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'library'       => 'all',
			),
			array(
				'key'          => 'field_product_short_benefits',
				'label'        => 'Short Benefits',
				'name'         => 'product_short_benefits',
				'type'         => 'textarea',
				'instructions' => 'One or two short benefit lines shown on the card. e.g. "Fine hair, oily roots\nVolume - Strength".',
				'required'     => 0,
				'rows'         => 2,
				'new_lines'    => '',
			),
			array(
				'key'          => 'field_product_score',
				'label'        => 'Score',
				'name'         => 'product_score',
				'type'         => 'number',
				'instructions' => 'Rating score from 0 to 5. Leave blank to hide stars.',
				'required'     => 0,
				'min'          => 0,
				'max'          => 5,
				'step'         => 0.1,
			),
			array(
				'key'          => 'field_product_price',
				'label'        => 'Price',
				'name'         => 'product_price',
				'type'         => 'text',
				'instructions' => 'Display price, e.g. "29,00 €". Leave blank to hide.',
				'required'     => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'selecta_product',
				),
			),
		),
		'menu_order'      => 10,
		'position'        => 'side',
		'style'           => 'default',
		'label_placement' => 'top',
	) );

	acf_add_local_field_group( array(
		'key'    => 'group_header_nav_panels',
		'title'  => 'Navigation Panels',
		'fields' => array(
			array(
				'key'          => 'field_nav_panels',
				'label'        => 'Panels',
				'name'         => 'nav_panels',
				'type'         => 'repeater',
				'instructions' => 'Add one panel per top-level nav item. Use the same full CSS class in Panel Key and on the WP menu item, e.g. <code>panel-key-complements</code>.',
				'button_label' => 'Add Panel',
				'layout'       => 'block',
				'sub_fields'   => array(
					array(
						'key'          => 'field_nav_panel_key',
						'label'        => 'Panel Key',
						'name'         => 'panel_key',
						'type'         => 'text',
						'instructions' => 'Paste the full CSS class here, e.g. <code>panel-key-complements</code>. Add the same class in Appearance > Menus on that menu item (Screen Options > CSS Classes).',
						'required'     => 1,
					),
					array(
						'key'           => 'field_nav_panel_type',
						'label'         => 'Panel Type',
						'name'          => 'panel_type',
						'type'          => 'select',
						'choices'       => array(
							'simple' => 'Simple — images with links',
							'mega'   => 'Mega menu — link columns',
						),
						'default_value' => 'simple',
						'required'      => 1,
					),
					array(
						'key'               => 'field_nav_panel_featured_items',
						'label'             => 'Featured Items',
						'name'              => 'featured_items',
						'type'              => 'repeater',
						'instructions'      => 'Add up to 5 items with image, title, and link.',
						'button_label'      => 'Add Item',
						'layout'            => 'table',
						'max'               => 5,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_nav_panel_type',
									'operator' => '==',
									'value'    => 'simple',
								),
							),
						),
						'sub_fields'        => array(
							array(
								'key'           => 'field_nav_panel_item_image',
								'label'         => 'Image',
								'name'          => 'item_image',
								'type'          => 'image',
								'return_format' => 'id',
								'preview_size'  => 'thumbnail',
								'library'       => 'all',
							),
							array(
								'key'   => 'field_nav_panel_item_title',
								'label' => 'Title',
								'name'  => 'item_title',
								'type'  => 'text',
							),
							array(
								'key'   => 'field_nav_panel_item_url',
								'label' => 'URL',
								'name'  => 'item_url',
								'type'  => 'url',
							),
						),
					),
					array(
						'key'               => 'field_nav_panel_mega_columns',
						'label'             => 'Mega Menu Columns',
						'name'              => 'mega_columns',
						'type'              => 'repeater',
						'instructions'      => 'Add columns, each with an optional heading and a list of links.',
						'button_label'      => 'Add Column',
						'layout'            => 'block',
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_nav_panel_type',
									'operator' => '==',
									'value'    => 'mega',
								),
							),
						),
						'sub_fields'        => array(
							array(
								'key'   => 'field_nav_mega_col_title',
								'label' => 'Column Title',
								'name'  => 'column_title',
								'type'  => 'text',
							),
							array(
								'key'          => 'field_nav_mega_col_links',
								'label'        => 'Links',
								'name'         => 'column_links',
								'type'         => 'repeater',
								'button_label' => 'Add Link',
								'layout'       => 'table',
								'sub_fields'   => array(
									array(
										'key'   => 'field_nav_mega_link_text',
										'label' => 'Text',
										'name'  => 'link_text',
										'type'  => 'text',
									),
									array(
										'key'   => 'field_nav_mega_link_url',
										'label' => 'URL',
										'name'  => 'link_url',
										'type'  => 'url',
									),
								),
							),
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'selecta-nav-panels',
				),
			),
		),
		'menu_order'      => 0,
		'position'        => 'normal',
		'style'           => 'default',
		'label_placement' => 'top',
	) );

	acf_add_local_field_group( array(
		'key'    => 'group_product_category_banner',
		'title'  => 'Category Page',
		'fields' => array(
			array(
				'key'           => 'field_category_banner_image',
				'label'         => 'Banner Image',
				'name'          => 'category_banner_image',
				'type'          => 'image',
				'instructions'  => 'Wide banner image for this category page. Recommended: 1920×605 px.',
				'required'      => 0,
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'library'       => 'all',
			),
			array(
				'key'          => 'field_category_intro_text',
				'label'        => 'Intro Text',
				'name'         => 'category_intro_text',
				'type'         => 'wysiwyg',
				'instructions' => 'Centered text shown below the banner. Use bold for product or range names.',
				'required'     => 0,
				'tabs'         => 'all',
				'toolbar'      => 'basic',
				'media_upload' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'taxonomy',
					'operator' => '==',
					'value'    => 'selecta_product_category',
				),
			),
		),
		'menu_order'      => 0,
		'position'        => 'normal',
		'style'           => 'default',
		'label_placement' => 'top',
	) );
}
