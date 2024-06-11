<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Helper function
 *
 * @package EnfoldPlus
 */

class EnfoldPlusHelpers {
	
	static public function selector_generator( $el_class, $el_id = "" ){ 
		$el_class = implode( ".", array_filter( preg_split('/\s+/', $el_class ), function( $value ) { return !is_null( $value ) && $value !== ''; } ) );
		$el_id = !empty( $el_id ) ? "#" . $el_id : "";
		return "#top ." . $el_class . $el_id;
	}
	
	static public function build_responsive_style_tag( $selector, $atts, $desktop_key, $tablet_key = "", $mobile_key = "", $property = "" ) {
		$style_content = "";
	
		ob_start();
		?>
			<?php echo $selector; ?>{ <?php echo AviaHelper::style_string( $atts, $desktop_key, $property, "!important" ); ?> }
			<?php if( $tablet_key && $atts[$tablet_key] !== '' ): ?>
			@media only screen and (max-width: 989px) { <?php echo $selector; ?>{ <?php echo AviaHelper::style_string( $atts, $tablet_key, $property, "!important" ); ?> } }
			<?php endif; ?>
			<?php if( $mobile_key && $atts[$mobile_key] !== '' ): ?>
			@media only screen and (max-width: 767px) { <?php echo $selector; ?>{ <?php echo AviaHelper::style_string( $atts, $mobile_key, $property, "!important" ); ?> } }
			<?php endif; ?>
		<?php
		
		$style_content .= ob_get_clean();
	
		return $style_content;
	}
	
	static public function attribute_exploder( $array ) {
		$array_exploded = explode(',', $array);
		if( count( $array_exploded ) > 1) {
			$array = "";
			foreach( $array_exploded as $value ) {
				if( empty( $value ) ) $value = "0";
				$array .= $value . " ";
			}
		}
		return $array;
	}

	static public function get_responsive_image( $atts, $keys = array(), $flickity_lazy_load = false ){
		$output = "";

		$desktop_image = $atts[$keys['desktop']];
		$tablet_image = $atts[$keys['tablet']];
		$mobile_image = $atts[$keys['mobile']];
		
		$default_image = wp_get_attachment_image( $desktop_image, 'full', false, array( 
			'class' => $flickity_lazy_load ? 'flickity-lazyload-enabled' : '', 
			'srcset' => '', 
			'sizes' => '',
			'loading' => 'lazy'
		) );

		if( ! empty( $tablet_image ) || ! empty( $mobile_image ) ) {

			$desktop_url = wp_get_attachment_image_url( $desktop_image, 'full' );
			$output .= "<picture>";
			
			if( isset( $mobile_image ) && ! empty( $mobile_image ) ) {
				$url = wp_get_attachment_image_url( $mobile_image, 'full' );
				$output .= "<source media='(max-width: 767px)' srcset='{$url}'>";
			}

			if( isset( $tablet_image ) && ! empty( $tablet_image ) ) {
				$url = wp_get_attachment_image_url( $tablet_image, 'full' );
				$output .= "<source media='(max-width: 989px)' srcset='{$url}'>";
			}

			$output .= "<source srcset='{$desktop_url}'>";

			$output .= $default_image;
			$output .= "</picture>";

		} else {
			$output .= $default_image;
		}

		if( $flickity_lazy_load ){
			$output = str_replace( 'src', 'data-flickity-lazyload-src', $output );
		}

		return $output;
	}
	
	static public function get_custom_posts( $post_type = 'post' ) {
	
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => $post_type,
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
	
		$posts_array = get_posts( $args ); 
		$post_type_option = array();
	
		if( !empty( $posts_array ) ) {
			foreach( $posts_array as $post_array ) {	
				$post_type_option[$post_array->post_title] = $post_array->ID;
			}
		}
	
		return $post_type_option;
	
	}
	
	static private function get_terms( $post_id, $taxonomy, $separator, $limit = false, $links = true ) {

		/* If term is publicly_queryable false force no links since there won't be archive view */
		if( get_taxonomy( $taxonomy ) && get_taxonomy( $taxonomy )->publicly_queryable == false ) {
			$links = false;
		}

		$output = "";
		$term_tag = $links ? "a" : "span";

		if( has_term( "", $taxonomy, $post_id ) ) {
			$terms_html_array = array();
			$terms_array = apply_filters( 'avf_ep_get_terms_array', get_the_terms( $post_id, $taxonomy ), $taxonomy, $post_id );
			
			if( $terms_array ){
				$i = 0;

				foreach( $terms_array as $term ){
					$term_link = $links ? "href='" . esc_url( get_term_link( $term, $taxonomy ) ) . "'" : "";
					$term_link = apply_filters( 'avf_ep_get_terms_term_link', $term_link, $term, $taxonomy, $post_id );
					$term_slug = apply_filters( 'avf_ep_get_terms_term_slug', $term->slug, $term, $taxonomy, $post_id );
					$term_name = apply_filters( 'avf_ep_get_terms_term_name', $term->name, $term, $taxonomy, $post_id );

					$terms_html_array[] = "<{$term_tag} class='ep-item-term ep-item-term-{$term_slug}' {$term_link}>" . $term_name . "</{$term_tag}>";

					if ( $limit && ( ++$i == $limit ) ) break;
				}

				$output = implode( $separator, $terms_html_array );
			}
		}

		return $output;

	}

	static public function get_terms_with_links( $post_id, $taxonomy, $separator, $limit = false ) {

		return self::get_terms( $post_id, $taxonomy, $separator, $limit, true );
			
	}

	static public function get_terms_without_links( $post_id, $taxonomy, $separator, $limit = false ) {

		return self::get_terms( $post_id, $taxonomy, $separator, $limit, false );

	}

	/* Default Atts helpers */
	static public function query_atts() {
		return array(
			'items' => '12',
			'post_type' => 'post',
			'categories' => '',
			'taxonomy' => '',
			'categories2' => '',
			'taxonomy2' => '',
			'categories3' => '',
			'taxonomy3' => '',
			'query_orderby' => 'date',
			'query_order' => 'DESC',
			'query_post__in' => '',
			'query_post__not_in' => '',
			'query_post_parent' => '',
		);
	}
	
	static public function columns_atts() {
		return array(
			'columns' => '4',
			'columns_tablet' => '2',
			'columns_mobile' => '1',
			'gap' => '',
		);
	}

	static public function grid_atts() {
		return array(
			'layout' => '',
			'grid_alignment' => '', 
			'grid_alignment_v' => '', 
		);
	}

	
	static public function slider_atts() {
		return array(
			'draggable' => '',
			'draggable_tablet' => '',
			'draggable_mobile' => '',
			'freescroll' => '',
			'freescroll_tablet' => '',
			'freescroll_mobile' => '',
			'wrap_around' => 'yes',
			'wrap_around_tablet' => '',
			'wrap_around_mobile' => '',
			'prev_next_buttons' => '',
			'prev_next_buttons_tablet' => '',
			'prev_next_buttons_mobile' => '',
			'page_dots' => '',
			'page_dots_tablet' => '',
			'page_dots_mobile' => '',
			'adaptive_height' => '',
			'adaptive_height_tablet' => '',
			'adaptive_height_mobile' => '',
			'autoplay' => '',
			'autoplay_speed' => '',
			'autoplay_tablet' => '',
			'autoplay_tablet_speed' => '',
			'autoplay_mobile' => '',
			'autoplay_mobile_speed' => '',
			'fade' => '',
			'fade_tablet' => '',
			'fade_mobile' => '',
			'cell_align' => '',
			'cell_align_tablet' => '',
			'cell_align_mobile' => '',
			'group_cells' => 'true',
			'group_cells_tablet' => '',
			'group_cells_mobile' => '',
			'initial_index' => '',
			'initial_index_tablet' => '',
			'initial_index_mobile' => '',
			'contain' => '',
			'contain_tablet' => '',
			'contain_mobile' => '',
			'watch_css' => '',
			'lazy_load' => '',
			'selected_attraction' => '',
			'friction' => '',
			'as_nav_for' => '',
			'sync' => '',
			'hash' => '',
			'images_loaded' => '',
		);
	}

	static public function item_atts() {
		return array(
			"media_size" => "",
			"media_position" => "",
			"media_space" => "",
			"title_space" => "",
			"heading_type" => "h4",
			"content_alignment" => "",
			"vertical_alignment" => "",
			"item_fill" => "",
			"button_link" => "",
			"button_color" => "",
			"link_label" => "",
			"color" => "",
			"custom_color" => "",
			"content_color" => "",
			"content_custom_color" => "",
			"icon_color" => "",
			"icon_custom_color" => "",
			"size" => "",
			"custom_size" => "",
			"content_size" => "",
			"content_custom_size" => "",
			"animation" => "",
			"item_template_option" => "",
			"item_template_file" => "",
		);
	}

	static public function post_item_atts() {
		return array(
			"media_size" => "",
			"media_position" => "",
			"media_space" => "",
			"title_space" => "",
			"heading_type" => "h4",
			"content_alignment" => "",
			"vertical_alignment" => "",
			"item_fill" => "",
			"button_link" => "",
			"button_color" => "",
			"link_label" => "",
			"post_taxonomy" => "",
			"post_terms_number" => "",
			"post_item_custom_class" => "",
			"excerpt_length" => "",
			"date_format" => "",
			"disable_image" => "",
			"disable_tax" => "",
			"disable_date" => "",
			"disable_title" => "",
			"disable_content" => "",
			"disable_link" => "",
			"disable_term_links" => "",
			"disable_button" => "",
			"color" => "",
			"custom_color" => "",
			"content_color" => "",
			"content_custom_color" => "",
			"icon_color" => "",
			"icon_custom_color" => "",
			"size" => "",
			"custom_size" => "",
			"content_size" => "",
			"content_custom_size" => "",
			"animation" => "",
			"item_template_option" => "",
			"item_template_file" => "",
		);
	}
	
	static public function get_column_class( $columns, $columns_tablet, $columns_mobile ) {
		switch( $columns ) {
			case "1": $column_class_desktop = 'is-full-desktop';   break;
			case "2": $column_class_desktop = 'is-half-desktop';   break;
			case "3": $column_class_desktop = 'is-one-third-desktop';  break;
			case "4": $column_class_desktop = 'is-one-quarter-desktop';  break;
			case "5": $column_class_desktop = 'is-one-fifth-desktop';   break;
			case "6": $column_class_desktop = 'is-2-desktop';  break;
		}
		
		
		switch( $columns_tablet ) {
			case "1": $column_class_tablet = 'is-full-tablet';   break;
			case "2": $column_class_tablet = 'is-half-tablet';   break;
			case "3": $column_class_tablet = 'is-one-third-tablet';  break;
			case "4": $column_class_tablet = 'is-one-quarter-tablet';  break;
			case "5": $column_class_tablet = 'is-one-fifth-tablet';   break;
			case "6": $column_class_tablet = 'is-2-tablet';   break;
			default: $column_class_tablet = str_replace( 'desktop', 'tablet', $column_class_desktop );
		}
	
	
		switch( $columns_mobile ) {
			case "1": $column_class_mobile = 'is-full-mobile';   break;
			case "2": $column_class_mobile = 'is-half-mobile';   break;
			case "3": $column_class_mobile = 'is-one-third-mobile';  break;
			case "4": $column_class_mobile = 'is-one-quarter-mobile';  break;
			case "5": $column_class_mobile = 'is-one-fifth-mobile';   break;
			case "6": $column_class_mobile = 'is-2-mobile';   break;
			default: $column_class_mobile = str_replace( 'desktop', 'mobile', $column_class_desktop );
		}
	
		return $column_class_mobile . " " . $column_class_tablet . " " . $column_class_desktop;
	}
	
	static public function get_post_vars( $post_id, $atts ) {
		
		extract( $atts );

		if (! isset( $sc_base_classes ) ) {
			$sc_base_classes = '';
		}

		if (! isset( $post_item_custom_class ) ) {
			$post_item_custom_class = '';
		}

		/* passed from element options */
		$post_taxonomy = !empty( $post_taxonomy ) ? $post_taxonomy : 'category';
		$post_terms_number = !empty( $post_terms_number ) ? $post_terms_number : false;
		$excerpt_length = !empty( $excerpt_length ) ? $excerpt_length : 120;
		$date_format = !empty( $date_format ) ? $date_format : get_option( 'date_format' );
		$post_type_slug = get_post_type( $post_id );

		$permalink = apply_filters( "avf_ep_post_item_link", get_permalink( $post_id ), $post_type_slug, $post_id, $meta, $shortcode );
		$link_attrs = apply_filters( "avf_ep_post_item_link_attrs", "", $post_type_slug, $post_id, $meta, $shortcode );
		$item_taxonomy = apply_filters( "avf_ep_post_item_taxonomy", $post_taxonomy, $post_type_slug, $post_id, $meta, $shortcode );
		$post_content_length = apply_filters( "avf_ep_post_item_content_length", $excerpt_length, $post_type_slug, $post_id, $meta, $shortcode );
		$post_image = apply_filters( "avf_ep_post_item_image", wp_get_attachment_image( get_post_thumbnail_id( $post_id ), 'post-thumbnail', false, array( 'loading' => 'lazy' ) ), $post_type_slug, $post_id, $meta, $shortcode );
		$post_classes = apply_filters( "avf_ep_post_item_classes", array( 
			"sc_base_classes" => $sc_base_classes, // item-grid class, column class, etc
			"base_class" => "entry", 
			"id_class" => "entry-{$post_id}", 
			"slug_class" => "entry-{$post_type_slug}",
			"custom_item_class" => $post_item_custom_class
		), $post_type_slug, $post_id, $meta, $shortcode );
		
		$post_vars = array(
			"post_content" => apply_filters( "avf_ep_post_item_content", get_the_excerpt( $post_id ) ? avia_backend_truncate( get_the_excerpt( $post_id ), $post_content_length, " ", "...", true) : avia_backend_truncate( strip_tags( get_post_field( 'post_content', $post_id ) ), $post_content_length, " ", "...", true ), $post_type_slug, $post_id, $meta, $shortcode ),
			"permalink" => $permalink,
			"link_attrs" => $link_attrs,
			"post_image" => $post_image, 
			"post_date" => apply_filters( "avf_ep_post_item_date", get_the_date( $date_format, $post_id ), $post_type_slug, $post_id, $meta, $shortcode ),
			"post_title" => apply_filters( "avf_ep_post_item_title", get_the_title( $post_id ), $post_type_slug, $post_id, $meta, $shortcode ),
			"item_taxonomy" => $item_taxonomy,
			"link_before" => "",
			"link_after" => "",
			"inner_link_before" => "",
			"inner_link_after" => "",
			"post_terms" => "",
			"post_type_slug" => $post_type_slug,
			"post_classes" => implode( " ", $post_classes )
		);

		$term_with_links = EnfoldPlusHelpers::get_terms_with_links( $post_id, $item_taxonomy, ", ", $post_terms_number );
		$term_without_links = EnfoldPlusHelpers::get_terms_without_links( $post_id, $item_taxonomy, ", ", $post_terms_number );
		
		if( empty( $disable_link ) ) {
			if( empty( $button_link ) ) {
				$post_vars["link_before"] = "<a class='noHover ep-link-wrapper' href='{$permalink}' {$link_attrs}>";
				$post_vars["link_after"] = "</a>";
				$post_vars["post_terms"] = $term_without_links;
			} else {
				$post_vars["inner_link_before"] = "<a class='noHover' href='{$permalink}' {$link_attrs}>";
				$post_vars["inner_link_after"] = "</a>";
				if( empty( $disable_term_links ) ) {
					$post_vars["post_terms"] = $term_with_links;
				} else {
					$post_vars["post_terms"] = $term_without_links;
				}
			}
		} else {
			$post_vars["post_terms"] = $term_without_links;
		}

		return apply_filters( "avf_ep_post_item_vars", $post_vars, $post_type_slug, $post_id, $meta, $shortcode );
	}

	static public function query_posts( $params, $meta, $shortcode ){

		$query = array();
		$is_paginable = $shortcode == 'ep_post_grid' ? true : false;

		if( !empty( $params['categories'] ) ) {
			$terms 	= explode( ',', $params['categories'] );
		}

		if( !empty( $params['categories2'] ) ) {
			$terms2 = explode( ',', $params['categories2'] );
		}

		if( !empty( $params['categories3'] ) ) {
			$terms3 = explode( ',', $params['categories3'] );
		}


		//if we find categories perform complex query, otherwise simple one
		if( isset( $terms[0] ) && !empty( $terms[0] ) && !is_null( $terms[0] ) && $terms[0] != "null" ) {
			$query = array(	'orderby' 	=> $params['query_orderby'],
							'order' 	=> $params['query_order'],
							'posts_per_page' => $params['items'],
							'post_type' => $params['post_type'],
							'tax_query' => array( 	
									array( 	
											'taxonomy' 	=> $params['taxonomy'],
											'field' 	=> 'id',
											'terms' 	=> $terms,
											'operator' 	=> 'IN'
									)
								)
							);

			if( isset( $terms2[0] ) && !empty( $terms2[0] ) && !is_null( $terms2[0] ) && $terms2[0] != "null" ){

				$query['tax_query']['relation'] = "AND"; // TODO add relation option

				$query['tax_query'][] = array(
					'taxonomy' 	=> $params['taxonomy2'],
					'field' 	=> 'id',
					'terms' 	=> $terms2,
					'operator' 	=> 'IN'
				);
			}

			if( isset( $terms3[0] ) && !empty( $terms3[0] ) && !is_null( $terms3[0] ) && $terms3[0] != "null" ){
				$query['tax_query'][] = array(
					'taxonomy' 	=> $params['taxonomy3'],
					'field' 	=> 'id',
					'terms' 	=> $terms3,
					'operator' 	=> 'IN'
				);					
			}


		} else {
			$query = array(	'orderby' 	=> $params['query_orderby'],
							'order' 	=> $params['query_order'],
							'posts_per_page' => $params['items'], 
							'post_type' => $params['post_type']);
		}
		
		$query['facetwp'] = false;
		// FacetWP only kicks in when pagination is not "Load More".
		if( !empty( $params['facetwp'] ) && $params['paginate'] != 'yes' ) {
			$query['facetwp'] = true;
		}
		if( $is_paginable && $params['paginate'] != "no" ) {
			$query['offset'] = $params['offset'];
		}

		if( !empty( $params['query_post__not_in'] ) ) {
			$query['post__not_in'] = explode( ',', $params['query_post__not_in'] );
		}

		if( !empty( $params['query_post__in'] ) ) {
			$query['post__in'] = explode( ',', $params['query_post__in'] );
		}

		if( !empty( $params['query_post_parent'] ) ) {
			$query['post_parent'] = $params['query_post_parent'];
		}

		$query['post_status'] = 'publish';
		$query['supress_filters'] = true;
		$query['ignore_sticky_posts'] = true;
		
		$query = apply_filters( "avf_{$shortcode}_query", $query, $meta );
		
		return apply_filters( "avf_{$shortcode}_query_object", new WP_Query( $query ), $meta );

	}

	static public function get_flickity_data( $atts ) {
	
		extract( $atts );
	
		$flickity_is_responsive = false;
		$flickity_options = array();
		$flickity_options_tablet = array();
		$flickity_options_mobile = array();
	
		$autoplay_value = !empty( $autoplay_speed ) && $autoplay == 'yes' ? intval( $autoplay_speed ) : ( $autoplay == 'yes' ? : false );
		$autoplay_tablet_value = !empty( $autoplay_tablet_speed ) && $autoplay_tablet == 'yes' ? intval( $autoplay_tablet_speed ) : ( $autoplay_tablet == 'yes' ? : false );
		$autoplay_mobile_value = !empty( $autoplay_mobile_speed ) && $autoplay_mobile == 'yes' ? intval( $autoplay_mobile_speed ) : ( $autoplay_mobile == 'yes' ? : false );

		/* Default */
		if( !empty( $draggable ) ) $flickity_options['draggable'] = false;
		if( !empty( $freescroll ) ) $flickity_options['freeScroll'] = true;
		if( !empty( $wrap_around ) ) $flickity_options['wrapAround'] =  true;
		if( !empty( $prev_next_buttons ) ) $flickity_options['prevNextButtons'] = false;
		if( !empty( $page_dots ) ) $flickity_options['pageDots'] = false;
		if( !empty( $cell_align ) ) $flickity_options['cellAlign'] = $cell_align;
		if( !empty( $group_cells ) ) $flickity_options['groupCells'] = $group_cells == "true" ? true : intval( $group_cells );
		if( !empty( $contain ) ) $flickity_options['contain'] = $contain == "yes" ? true : false;
		if( !empty( $fade ) ) $flickity_options['fade'] = true;
		if( !empty( $adaptive_height ) ) $flickity_options['adaptiveHeight'] = true;
		if( !empty( $watch_css ) ) $flickity_options['watchCSS'] = true;
		if( !empty( $lazy_load ) ) $flickity_options['lazyLoad'] = true;
		if( !empty( $autoplay_value ) ) $flickity_options['autoPlay'] = $autoplay_value;
		if( !empty( $selected_attraction ) ) $flickity_options['selectedAttraction'] = $selected_attraction;
		if( !empty( $friction ) ) $flickity_options['friction'] = $friction;
		if( !empty( $as_nav_for ) ) $flickity_options['asNavFor'] = $as_nav_for;
		if( !empty( $sync ) ) $flickity_options['sync'] = $sync;
		if( !empty( $hash ) ) $flickity_options['hash'] = $hash;
		if( !empty( $images_loaded ) ) $flickity_options['imagesLoaded'] = $images_loaded;
		if( !empty( $initial_index ) ) $flickity_options['initialIndex'] = $initial_index;

		/* Tablet */
		if( !empty( $draggable_tablet ) ) $flickity_options_tablet['draggable'] = $draggable_tablet == "no" ? false : true;
		if( !empty( $freescroll_tablet ) ) $flickity_options_tablet['freeScroll'] = $freescroll_tablet == "yes" ? true : false;
		if( !empty( $wrap_around_tablet ) ) $flickity_options_tablet['wrapAround'] = $wrap_around_tablet == "yes" ? true : false;
		if( !empty( $prev_next_buttons_tablet ) ) $flickity_options_tablet['prevNextButtons'] = $prev_next_buttons_tablet == "no" ? false : true;
		if( !empty( $page_dots_tablet ) ) $flickity_options_tablet['pageDots'] = $page_dots_tablet == "no" ? false : true;

		if( !empty( $group_cells_tablet ) ) $flickity_options_tablet['groupCells'] = $group_cells_tablet == "true" ? true : intval( $group_cells_tablet );
		if( !empty( $contain_tablet ) ) $flickity_options_tablet['contain'] = $contain_tablet == "yes" ? true : false;
		if( !empty( $fade_tablet ) ) $flickity_options_tablet['fade'] = $fade_tablet == "yes" ? true : false;
		if( !empty( $adaptive_height_tablet ) ) $flickity_options_tablet['adaptiveHeight'] = $adaptive_height_tablet == "yes" ? true : false;
		if( !empty( $autoplay_tablet_value ) ) $flickity_options_tablet['autoPlay'] = $autoplay_tablet_value;
		if( !empty( $cell_align_tablet ) ) $flickity_options_tablet['cellAlign'] = $cell_align_tablet;
		if( !empty( $initial_index_tablet ) ) $flickity_options_tablet['initialIndex'] = $initial_index_tablet;

		/* Mobile */
		if( !empty( $draggable_mobile ) ) $flickity_options_mobile['draggable'] = $draggable_mobile == "yes" ? true : false;
		if( !empty( $freescroll_mobile ) ) $flickity_options_mobile['freeScroll'] = $freescroll_mobile == "yes" ? true : false;
		if( !empty( $wrap_around_mobile ) ) $flickity_options_mobile['wrapAround'] = $wrap_around_mobile == "yes" ? true : false;
		if( !empty( $prev_next_buttons_mobile ) ) $flickity_options_mobile['prevNextButtons'] = $prev_next_buttons_mobile == "yes" ? true : false;
		if( !empty( $page_dots_mobile ) ) $flickity_options_mobile['pageDots'] = $page_dots_mobile == "yes" ? true : false;

		if( !empty( $group_cells_mobile ) ) $flickity_options_mobile['groupCells'] = $group_cells_mobile == "true" ? true : intval( $group_cells_mobile );
		if( !empty( $contain_mobile ) ) $flickity_options_mobile['contain'] = $contain_mobile == "yes" ? true : false;
		if( !empty( $fade_mobile ) ) $flickity_options_mobile['fade'] = $fade_mobile == "yes" ? true : false;
		if( !empty( $adaptive_height_mobile ) ) $flickity_options_mobile['adaptiveHeight'] = $adaptive_height_mobile == "yes" ? true : false;
		if( !empty( $autoplay_mobile_value ) ) $flickity_options_mobile['autoPlay'] = $autoplay_mobile_value;
		if( !empty( $cell_align_mobile ) ) $flickity_options_mobile['cellAlign'] = $cell_align_mobile;
		if( !empty( $initial_index_mobile ) ) $flickity_options_mobile['initialIndex'] = $initial_index_mobile;
	
		if( !empty( $flickity_options_tablet ) || !empty( $flickity_options_mobile ) ) $flickity_is_responsive = true;
	
		$flickity_options_tablet = !empty( $flickity_options_tablet ) ? "data-ep-flickity-tablet='" . json_encode( array_merge( $flickity_options, $flickity_options_tablet ) ) . "'" : "";
		$flickity_options_mobile = !empty( $flickity_options_mobile ) ? "data-ep-flickity-mobile='" . json_encode( array_merge( $flickity_options, $flickity_options_mobile ) ) . "'" : "";
		$flickity_options = json_encode( $flickity_options );
		
		return $flickity_is_responsive ? "data-ep-flickity='{$flickity_options}' {$flickity_options_tablet} {$flickity_options_mobile}" : "data-flickity='{$flickity_options}'";
		
	}
	
	static public function flickity_assets( $bulma = true, $extra = false ) {
		if( $bulma ){
			wp_enqueue_style( 'avia-module-ep-bulma-grid' , ENFOLD_PLUS_ASSETS . 'css/dist/bulma_grid.css', array( 'avia-layout' ), ENFOLD_PLUS_VERSION, 'all' );
		}
		
		wp_enqueue_style( 'avia-module-ep-flickity' , ENFOLD_PLUS_ASSETS . 'css/dist/flickity.css', array(), ENFOLD_PLUS_VERSION, 'all' );
		wp_enqueue_script( 'avia-module-ep-flickity', ENFOLD_PLUS_ASSETS . 'js/dist/flickity.js', array(), ENFOLD_PLUS_VERSION, true );
		wp_enqueue_script( 'avia-module-ep-flickity-fade', ENFOLD_PLUS_ASSETS . 'js/dist/flickity-fade.js', array( 'avia-module-ep-flickity' ), ENFOLD_PLUS_VERSION, true );
		wp_enqueue_script( 'avia-module-ep-enquire', ENFOLD_PLUS_ASSETS . 'js/dist/enquire.js', array(), ENFOLD_PLUS_VERSION, true );
		wp_enqueue_script( 'avia-module-ep-flickity-sync', ENFOLD_PLUS_ASSETS . 'js/dist/flickity-sync.js', array( 'avia-module-ep-flickity' ), ENFOLD_PLUS_VERSION, true );
		wp_enqueue_script( 'avia-module-ep-flickity-as-nav-for', ENFOLD_PLUS_ASSETS . 'js/dist/flickity-as-nav-for.js', array( 'avia-module-ep-flickity' ), ENFOLD_PLUS_VERSION, true );		
		wp_enqueue_script( 'avia-module-ep-flickity-prev-next', ENFOLD_PLUS_ASSETS . 'js/dist/flickity-prev-next.js', array( 'avia-module-ep-flickity' ), ENFOLD_PLUS_VERSION, true );		
		wp_enqueue_script( 'avia-module-ep-flickity-hash', ENFOLD_PLUS_ASSETS . 'js/dist/flickity-hash.js', array( 'avia-module-ep-flickity' ), ENFOLD_PLUS_VERSION, true );		

		wp_enqueue_style( 'avia-module-ep-flickity-slider' , ENFOLD_PLUS_ASSETS . 'css/ep_flickity_slider.css', array( 'avia-module-ep-bulma-grid' ), ENFOLD_PLUS_VERSION, 'all' );
		wp_enqueue_script( 'avia-module-ep-flickity-slider', ENFOLD_PLUS_ASSETS . 'js/ep_flickity_slider.js', array( 'avia-module-ep-shortcodes-sc', 'avia-module-ep-enquire' ), ENFOLD_PLUS_VERSION, true );

	}
}