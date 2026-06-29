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
}
