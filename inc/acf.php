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
		'layout_product_gallery' => array(
			'key'        => 'layout_product_gallery',
			'name'       => 'product_gallery',
			'label'      => 'Product Gallery & Hero Info',
			'display'    => 'block',
			'sub_fields' => array(
				array(
					'key'           => 'field_pg_images',
					'label'         => 'Gallery Images',
					'name'          => 'gallery_images',
					'type'          => 'gallery',
					'instructions'  => 'Upload all product images. The first image is the primary/main image.',
					'required'      => 0,
					'return_format' => 'id',
					'preview_size'  => 'thumbnail',
					'library'       => 'all',
					'min'           => 0,
					'max'           => 0,
				),
				array(
					'key'          => 'field_pg_subtitle',
					'label'        => 'Product Subtitle',
					'name'         => 'product_subtitle',
					'type'         => 'text',
					'instructions' => 'Short descriptor shown below the product name. e.g. "DUO COMPLÉMENT ALIMENTAIRE CAPSULES CHEVEUX & ONGLES".',
					'required'     => 0,
				),
				array(
					'key'          => 'field_pg_tag',
					'label'        => 'Product Tag',
					'name'         => 'product_tag',
					'type'         => 'text',
					'instructions' => 'Optional. Short tag shown in a bordered box. e.g. "1 Duo = 4 mois".',
					'required'     => 0,
				),
				array(
					'key'          => 'field_pg_hero_description',
					'label'        => 'Hero Description',
					'name'         => 'product_hero_description',
					'type'         => 'wysiwyg',
					'instructions' => 'Main product description. Use bold for emphasis. Shown below the tag.',
					'required'     => 0,
					'tabs'         => 'all',
					'toolbar'      => 'basic',
					'media_upload' => 0,
				),
				array(
					'key'          => 'field_pg_format',
					'label'        => 'Format / Size',
					'name'         => 'product_format',
					'type'         => 'text',
					'instructions' => 'Optional. Format or size shown above the rating. e.g. "120 caps x 2".',
					'required'     => 0,
				),
				array(
					'key'          => 'field_pg_review_count',
					'label'        => 'Review Count',
					'name'         => 'product_review_count',
					'type'         => 'number',
					'instructions' => 'Optional. Number of reviews. e.g. 84. Leave blank to hide.',
					'required'     => 0,
					'min'          => 0,
				),
				array(
					'key'          => 'field_pg_vegan_note',
					'label'        => 'Vegan Note',
					'name'         => 'product_vegan_note',
					'type'         => 'text',
					'instructions' => 'Optional. e.g. "Disponible en version végane". Leave blank to hide.',
					'required'     => 0,
				),
				array(
					'key'          => 'field_pg_variants',
					'label'        => 'Product Variants',
					'name'         => 'product_variants',
					'type'         => 'repeater',
					'instructions' => 'Optional. Alternate formats/sizes shown as circular images at the bottom.',
					'button_label' => 'Добави вариант',
					'layout'       => 'table',
					'required'     => 0,
					'sub_fields'   => array(
						array(
							'key'           => 'field_pg_variant_image',
							'label'         => 'Image',
							'name'          => 'variant_image',
							'type'          => 'image',
							'required'      => 0,
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
							'library'       => 'all',
						),
						array(
							'key'      => 'field_pg_variant_label',
							'label'    => 'Label',
							'name'     => 'variant_label',
							'type'     => 'text',
							'required' => 0,
						),
					),
				),
			),
		),
			'layout_product_text_and_image' => array(
				'key'        => 'layout_product_text_and_image',
				'name'       => 'product_text_and_image',
				'label'      => 'Text & Image',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'           => 'field_ptai_heading',
						'label'         => 'Section Heading',
						'name'          => 'section_heading',
						'type'          => 'text',
						'required'      => 0,
					),
					array(
						'key'          => 'field_ptai_body',
						'label'        => 'Body Text',
						'name'         => 'body_text',
						'type'         => 'wysiwyg',
						'instructions' => 'Supports bold text.',
						'required'     => 0,
						'tabs'         => 'all',
						'toolbar'      => 'basic',
						'media_upload' => 0,
					),
					array(
						'key'           => 'field_ptai_image',
						'label'         => 'Image',
						'name'          => 'image',
						'type'          => 'image',
						'required'      => 0,
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'library'       => 'all',
					),
					array(
						'key'           => 'field_ptai_image_position',
						'label'         => 'Layout',
						'name'          => 'image_position',
						'type'          => 'radio',
						'choices'       => array(
							'text_left'  => 'Text left, image right',
							'image_left' => 'Image left, text right',
						),
						'default_value' => 'text_left',
						'layout'        => 'horizontal',
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
				'key'           => 'field_nav_header_logo',
				'label'         => 'Header Logo',
				'name'          => 'nav_header_logo',
				'type'          => 'image',
				'instructions'  => 'Logo shown on the left of the site header. Recommended: square PNG/SVG, at least 112×112 px.',
				'required'      => 0,
				'return_format' => 'id',
				'preview_size'  => 'thumbnail',
				'library'       => 'all',
			),
			array(
				'key'           => 'field_nav_store_locator_url',
				'label'         => 'Store Locator URL',
				'name'          => 'nav_store_locator_url',
				'type'          => 'text',
				'instructions'  => 'Enter the path only — e.g. <code>/storelocator</code> or <code>/partnyori/</code>. The site domain is added automatically.',
				'placeholder'   => '/storelocator',
				'default_value' => '/storelocator',
				'required'      => 0,
			),
			array(
				'key'          => 'field_nav_panels',
				'label'        => 'Panels',
				'name'         => 'nav_panels',
				'type'         => 'repeater',
				'instructions' => 'Add one panel per top-level nav item. Use the same full CSS class in Panel Key and on the WP menu item, e.g. <code>panel-key-complements</code>.',
				'button_label' => 'Add Panel',
				'layout'       => 'block',
				'collapsed'    => 'field_nav_panel_key',
				'sub_fields'   => array(
					array(
					'key'          => 'field_nav_panel_key',
					'label'        => 'Panel Key',
					'name'         => 'panel_key',
					'type'         => 'text',
					'instructions' => '⚠️ IMPORTANT: The class MUST start with <strong>panel-key-</strong> — for example <code>panel-key-products</code> or <code>panel-key-hair-type</code>. Without this prefix the panel will NOT open on the site. Step 1: enter the full class here (e.g. <code>panel-key-products</code>). Step 2: go to Appearance → Menus, enable CSS Classes via Screen Options, and paste the exact same class on the matching menu item.',
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
						'layout'            => 'row',
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
								'key'          => 'field_nav_panel_item_title',
								'label'        => 'Title',
								'name'         => 'item_title',
								'type'         => 'wysiwyg',
								'tabs'         => 'all',
								'toolbar'      => 'basic',
								'media_upload' => 0,
							),
							array(
								'key'           => 'field_nav_panel_item_link_type',
								'label'         => 'Link Type',
								'name'          => 'item_link_type',
								'type'          => 'radio',
								'choices'       => array(
									'internal' => 'In-site link',
									'external' => 'Outside link',
								),
								'default_value' => 'internal',
								'layout'        => 'horizontal',
							),
							array(
								'key'               => 'field_nav_panel_item_link_path',
								'label'             => 'Path',
								'name'              => 'item_link_path',
								'type'              => 'text',
								'instructions'      => 'Enter the path only — e.g. <code>/products/</code> or <code>products/category/shampoo</code>. The site domain is added automatically.',
								'placeholder'       => '/products/',
								'conditional_logic' => array(
									array(
										array(
											'field'    => 'field_nav_panel_item_link_type',
											'operator' => '==',
											'value'    => 'internal',
										),
									),
								),
							),
							array(
								'key'               => 'field_nav_panel_item_url',
								'label'             => 'URL',
								'name'              => 'item_url',
								'type'              => 'url',
								'instructions'      => 'Full URL including https://',
								'conditional_logic' => array(
									array(
										array(
											'field'    => 'field_nav_panel_item_link_type',
											'operator' => '==',
											'value'    => 'external',
										),
									),
								),
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
								'layout'       => 'block',
								'sub_fields'   => array(
									array(
										'key'             => 'field_nav_mega_link_text',
										'label'           => 'Text',
										'name'            => 'link_text',
										'type'            => 'text',
										'label_placement' => 'left',
									),
									array(
										'key'             => 'field_nav_mega_link_type',
										'label'           => 'Link Type',
										'name'            => 'link_type',
										'type'            => 'radio',
										'choices'         => array(
											'internal' => 'In-site link',
											'external' => 'Outside link',
										),
										'default_value'   => 'internal',
										'layout'          => 'horizontal',
										'label_placement' => 'left',
									),
									array(
										'key'               => 'field_nav_mega_link_path',
										'label'             => 'Path',
										'name'              => 'link_path',
										'type'              => 'text',
										'instructions'      => 'Enter the path only — e.g. <code>/products/</code> or <code>products/category/shampoo</code>. The site domain is added automatically.',
										'placeholder'       => '/products/',
										'label_placement'   => 'left',
										'conditional_logic' => array(
											array(
												array(
													'field'    => 'field_nav_mega_link_type',
													'operator' => '==',
													'value'    => 'internal',
												),
											),
										),
									),
									array(
										'key'               => 'field_nav_mega_link_url',
										'label'             => 'URL',
										'name'              => 'link_url',
										'type'              => 'url',
										'instructions'      => 'Full URL including https://',
										'label_placement'   => 'left',
										'conditional_logic' => array(
											array(
												array(
													'field'    => 'field_nav_mega_link_type',
													'operator' => '==',
													'value'    => 'external',
												),
											),
										),
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

add_filter( 'acf/validate_value/key=field_nav_panel_key', 'selecta_validate_nav_panel_key', 10, 4 );
function selecta_validate_nav_panel_key( $valid, $value, $field, $input_name ) {
	if ( ! $valid ) {
		return $valid;
	}

	$value = trim( (string) $value );

	if ( '' !== $value && strpos( $value, 'panel-key-' ) !== 0 ) {
		return __( 'Panel Key must start with "panel-key-" — for example: panel-key-products', 'selecta-theme' );
	}

	return $valid;
}

add_filter( 'acf/load_field/key=field_nav_panel_item_link_path', 'selecta_nav_link_path_prepend' );
add_filter( 'acf/load_field/key=field_nav_mega_link_path', 'selecta_nav_link_path_prepend' );
add_filter( 'acf/load_field/key=field_nav_store_locator_url', 'selecta_nav_link_path_prepend' );
function selecta_nav_link_path_prepend( $field ) {
	$field['prepend'] = untrailingslashit( home_url() );

	return $field;
}

add_filter( 'acf/load_value/key=field_nav_store_locator_url', 'selecta_nav_store_locator_default_value', 10, 3 );
function selecta_nav_store_locator_default_value( $value, $post_id, $field ) {
	if ( '' === $value || null === $value || false === $value ) {
		return '/storelocator';
	}

	return $value;
}
