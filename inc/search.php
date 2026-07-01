<?php
/**
 * Product search: REST endpoint and search index builder.
 *
 * @package SelectaTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---------------------------------------------------------------------------
// Search index builder
// ---------------------------------------------------------------------------

/**
 * Build and store the search index meta for a single product.
 *
 * Fired on both native save_post and ACF save so either path keeps
 * the index current. The ACF hook can pass non-numeric values such as
 * 'options'; the numeric guard at the top handles that safely.
 *
 * @param mixed $post_id Post ID (may be string or non-post value from ACF hook).
 */
function selecta_build_search_index( $post_id ) {
	if ( ! is_numeric( $post_id ) ) {
		return;
	}

	$post_id = absint( $post_id );

	if ( 0 === $post_id ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( get_post_type( $post_id ) !== 'selecta_product' ) {
		return;
	}

	if ( get_post_status( $post_id ) === 'trash' ) {
		return;
	}

	$parts = array();

	// 1. Post title.
	$parts[] = get_the_title( $post_id );

	// 2. Product line terms.
	$line_terms = wp_get_object_terms( $post_id, 'selecta_product_line', array( 'fields' => 'names' ) );
	if ( ! is_wp_error( $line_terms ) ) {
		foreach ( $line_terms as $term_name ) {
			$parts[] = $term_name;
		}
	}

	// 3. Product category terms.
	$category_terms = wp_get_object_terms( $post_id, 'selecta_product_category', array( 'fields' => 'names' ) );
	if ( ! is_wp_error( $category_terms ) ) {
		foreach ( $category_terms as $term_name ) {
			$parts[] = $term_name;
		}
	}

	// 4. Hair concern terms.
	$concern_terms = wp_get_object_terms( $post_id, 'selecta_hair_concern', array( 'fields' => 'names' ) );
	if ( ! is_wp_error( $concern_terms ) ) {
		foreach ( $concern_terms as $term_name ) {
			$parts[] = $term_name;
		}
	}

	// 5. Hair type terms.
	$hair_type_terms = wp_get_object_terms( $post_id, 'selecta_hair_type', array( 'fields' => 'names' ) );
	if ( ! is_wp_error( $hair_type_terms ) ) {
		foreach ( $hair_type_terms as $term_name ) {
			$parts[] = $term_name;
		}
	}

	// 6. Short benefits (ACF textarea).
	if ( function_exists( 'get_field' ) ) {
		$short_benefits = get_field( 'product_short_benefits', $post_id );
		if ( $short_benefits && is_string( $short_benefits ) ) {
			$parts[] = wp_strip_all_tags( $short_benefits );
		}

		// 7. Badge (ACF text).
		$badge = get_field( 'product_badge', $post_id );
		if ( $badge && is_string( $badge ) ) {
			$parts[] = wp_strip_all_tags( $badge );
		}

		// 8. Product text & image layout body_text from product_sections flexible content.
		if ( function_exists( 'have_rows' ) && have_rows( 'product_sections', $post_id ) ) {
			while ( have_rows( 'product_sections', $post_id ) ) {
				the_row();
				$layout = get_row_layout();
				if ( 'product_text_and_image' === $layout ) {
					$body_text = get_sub_field( 'body_text' );
					if ( $body_text && is_string( $body_text ) ) {
						$parts[] = wp_strip_all_tags( $body_text );
					}
				}
			}
		}
	}

	$parts        = array_filter( $parts, 'is_string' );
	$parts        = array_filter( $parts );
	$index_string = implode( ' ', $parts );

	update_post_meta( $post_id, '_selecta_search_index', sanitize_textarea_field( $index_string ) );
}
add_action( 'save_post_selecta_product', 'selecta_build_search_index', 20 );
add_action( 'acf/save_post', 'selecta_build_search_index', 20 );

// ---------------------------------------------------------------------------
// REST endpoint
// ---------------------------------------------------------------------------

/**
 * Register the product search REST endpoint.
 */
function selecta_register_search_endpoint() {
	register_rest_route(
		'selecta/v1',
		'/search',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'selecta_search_endpoint_callback',
			'permission_callback' => '__return_true',
			'args'                => array(
				'q' => array(
					'type'              => 'string',
					'sanitize_callback' => function ( $value ) {
						return sanitize_text_field( wp_unslash( $value ) );
					},
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'selecta_register_search_endpoint' );

/**
 * Handle the /selecta/v1/search REST request.
 *
 * @param WP_REST_Request $request The incoming request object.
 * @return WP_REST_Response
 */
function selecta_search_endpoint_callback( WP_REST_Request $request ) {
	$raw_query = $request->get_param( 'q' );
	$query     = is_string( $raw_query ) ? trim( $raw_query ) : '';

	if ( mb_strlen( $query, 'UTF-8' ) < 3 ) {
		return rest_ensure_response( array() );
	}

	// Primary query: match against the search index meta.
	$index_query = new WP_Query(
		array(
			'post_type'              => 'selecta_product',
			'post_status'            => 'publish',
			'posts_per_page'         => 10,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_query'             => array(
				array(
					'key'     => '_selecta_search_index',
					'value'   => $query,
					'compare' => 'LIKE',
					'type'    => 'CHAR',
				),
			),
		)
	);

	$index_post_ids = wp_list_pluck( $index_query->posts, 'ID' );
	wp_reset_postdata();

	// Secondary query: match on post title.
	$title_query = new WP_Query(
		array(
			'post_type'              => 'selecta_product',
			'post_status'            => 'publish',
			'posts_per_page'         => 10,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			's'                      => $query,
		)
	);

	$title_post_ids = wp_list_pluck( $title_query->posts, 'ID' );
	wp_reset_postdata();

	// Merge title-first, deduplicate, limit to 10.
	$merged_ids = array();
	foreach ( array_merge( $title_post_ids, $index_post_ids ) as $id ) {
		if ( ! in_array( $id, $merged_ids, true ) ) {
			$merged_ids[] = $id;
		}
	}
	$merged_ids = array_slice( $merged_ids, 0, 10 );

	if ( empty( $merged_ids ) ) {
		return rest_ensure_response( array() );
	}

	$results = array();

	foreach ( $merged_ids as $post_id ) {
		$post = get_post( $post_id );

		if ( ! $post || $post->post_status !== 'publish' ) {
			continue;
		}

		// Product line: first term from selecta_product_line.
		$line       = '';
		$line_color = '';
		$line_terms = get_the_terms( $post_id, 'selecta_product_line' );
		if ( $line_terms && ! is_wp_error( $line_terms ) ) {
			$line       = $line_terms[0]->name;
			$line_color = selecta_get_product_line_color( $line_terms[0] );
		}

		// Short benefit: first line of product_short_benefits ACF field.
		$benefit = '';
		$score   = null;
		$price   = '';

		if ( function_exists( 'get_field' ) ) {
			$raw_benefit = get_field( 'product_short_benefits', $post_id );
			if ( $raw_benefit && is_string( $raw_benefit ) ) {
				$benefit_lines = explode( "\n", $raw_benefit );
				$benefit       = trim( wp_strip_all_tags( $benefit_lines[0] ) );
			}

			$score_raw = get_field( 'product_score', $post_id );
			if ( '' !== $score_raw && is_numeric( $score_raw ) ) {
				$score = max( 0, min( 5, (float) $score_raw ) );
			}

			$price_raw = get_field( 'product_price', $post_id );
			if ( is_string( $price_raw ) ) {
				$price = trim( $price_raw );
			}
		}

		// Featured image at medium size.
		$image_url = '';
		$image_alt = '';
		$thumb_id  = get_post_thumbnail_id( $post_id );
		if ( $thumb_id ) {
			$src = wp_get_attachment_image_src( (int) $thumb_id, 'medium' );
			if ( $src ) {
				$image_url = $src[0];
				$image_alt = trim( get_post_meta( (int) $thumb_id, '_wp_attachment_image_alt', true ) );
				if ( ! $image_alt ) {
					$image_alt = get_the_title( $post_id );
				}
			}
		}

		$results[] = array(
			'id'         => $post_id,
			'title'      => html_entity_decode( get_the_title( $post_id ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
			'url'        => get_permalink( $post_id ),
			'line'       => $line,
			'line_color' => $line_color,
			'benefit'    => $benefit,
			'score'     => $score,
			'price'     => $price,
			'image_url' => $image_url,
			'image_alt' => html_entity_decode( $image_alt, ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
		);
	}

	return rest_ensure_response( $results );
}
