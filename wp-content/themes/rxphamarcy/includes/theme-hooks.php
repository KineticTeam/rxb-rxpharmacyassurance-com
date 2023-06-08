<?php

/**
 * Debug mode
 */
function enfold_child_debug_mode(){
	return THEME_ENV === "development" ? "debug" : "";
}
add_action( 'avia_builder_mode', 'enfold_child_debug_mode' );

/**
 * BE Media from production hook, needed for local dev
 */
function enfold_child_prefix_production_url( $url ) {
	return REMOTE_URL;
}
add_filter( 'be_media_from_production_url', 'enfold_child_prefix_production_url' );

/**
 * Overrides Enfold Plus ALB Tab Name
 */
function enfold_child_tab_name(){
	return SITE_NAME;
}
add_filter( 'avf_ep_tab_name', 'enfold_child_tab_name', 1 );

/**
 * Overrides Enfold Plus Post Grid Template inclusion
 */
function enfold_child_posts_template_override( $template, $post_type, $post_id, $meta ){
	$post_template = THEME_INCLUDES . "loop-content-" . $post_type . ".php";

	if( file_exists( $post_template ) ) $template = $post_template;
	return $template;
}
add_filter( 'avf_ep_post_grid_post_template', 'enfold_child_posts_template_override', 10, 4 );
add_filter( 'avf_ep_post_slider_post_template', 'enfold_child_posts_template_override', 10, 4 );

/**
 * Overrides Enfold Plus Content Slider Template inclusion
 */
function enfold_child_slider_slide_template_override( $template, $atts, $meta ){
	/*
	if( strpos( $meta['custom_class'], 'custom' ) !== false ){
		$template = THEME_INCLUDES . "content-slider-custom.php";
	}
	*/

	return $template;
}
add_filter( 'avf_ep_content_slider_slide_template', 'enfold_child_slider_slide_template_override', 10, 3 );

/**
 * Overrides Enfold Plus Item Grid Template inclusion
 */
function enfold_child_logo_grid_item_override( $template, $atts, $meta ){
	/*
	if( strpos( $meta['custom_class'], 'custom' ) !== false ){
		$template = THEME_INCLUDES . "item-grid-custom.php";
	}
	*/

	return $template;
}
add_filter( 'avf_ep_item_grid_item_template', 'enfold_child_logo_grid_item_override', 10, 3 );

/**
 * Tab Slider Overrides
 */
function enfold_child_tab_slider_options( $options ) {
	/*
	$options[] = array(
		"name" 	=> __( "New option", 'avia_framework' ),
		"desc" 	=> __( "new option", 'avia_framework' ),
		"id" 	=> "new_option",
		"std" 	=> "",
		"type" 	=> "input"
	);
	*/

	return $options;
}
add_filter( 'avf_ep_tab_slider_options', 'enfold_child_tab_slider_options' );


function enfold_child_tab_slider_control_override( $template, $atts, $meta ){
	/*
	if( strpos( $meta['custom_class'], 'custom' ) !== false ){
		$template = THEME_INCLUDES . "avia-shortcodes/tab_slider/custom-control.php";
	}
	*/
	return $template;
}
add_filter( 'avf_ep_tab_slider_control_template', 'enfold_child_tab_slider_control_override', 10, 3 );

function enfold_child_tab_slider_slide_override( $template, $atts, $meta ){
	/*
	if( strpos( $meta['custom_class'], 'custom' ) !== false ){
		$template = THEME_INCLUDES . "avia-shortcodes/tab_slider/custom-slide.php";
	}
	*/
	return $template;
}
add_filter( 'avf_ep_tab_slider_slide_template', 'enfold_child_tab_slider_slide_override', 10, 3 );

/**
 * Button Colors
 * This hook will add/remove button color options on Buttons and Button Group
 */
function enfold_child_avf_button_colors($options) {
	$options = array(
		'Solid Primary' => 'solid-primary',
		'Solid Secondary' => 'solid-secondary',
		'Border Primary' => 'border-primary',
		'Border Secondary' => 'border-secondary',
		'Arrow Button' => 'arrow'
	);

	return $options;
}
add_filter( 'avf_ep_buttons_color_options', 'enfold_child_avf_button_colors', 10, 1 );

/**
 * Removes default heading font size
 */
function enfold_child_subheading_default_size( $heading ) {
	return '';
}
add_filter( 'avf_ep_subheading_default_size', 'enfold_child_subheading_default_size' );

/**
 * Google Fonts Hook
 */
function enfold_child_custom_google_fonts( $fonts ){
	// $fonts["Roboto"] = "Roboto:300,400,700";
	return $fonts;
}
add_filter( 'avf_google_heading_font', 'enfold_child_custom_google_fonts', 10, 2 );
add_filter( 'avf_google_content_font', 'enfold_child_custom_google_fonts', 10, 2 );

/**
 * Avia Shortcodes Hook
 */
function enfold_child_shortcodes( $paths ) {
	/* Note: if using a table.php replacement, you may want to run this at 20 priority so it loads before Enfold plus */
	$child_path = THEME_INCLUDES . "avia-shortcodes/";
	array_unshift( $paths, $child_path );

	return $paths;
}
add_filter( 'avia_load_shortcodes', 'enfold_child_shortcodes', 21, 1 );

/**
 * Hook into Sidebar options for custom header options
 */
function enfold_child_layout_elements( array $elements ) {
	foreach( $elements as $key => $element ) {

		switch($element['id']){
			case 'layout':
			case 'sidebar':
			case 'header_title_bar':
			case 'header_transparency':
			unset($elements[$key]);
			break;
		}

	}

	$elements[] = array(
		"slug"  => "layout",
		"name"  => __("Header Coloring",'avia_framework'),
		"id"    => "header_color",
		"desc"  => "Set header style for this Page",
		"type"  => "select",
		"std"   => "",
		"class" => "avia-style",
		"subtype" => array(
							__("Default",'avia_framework') => '',
							__('Alternate','avia_framework') => 'is-alternate',

				)
		);

    $elements[] = array(
        "slug"  => "layout",
        "name"  => __( "Announcement Banner",'avia_framework' ),
        "id"    => "announcement_banner",
        "desc"  => "Enables Announcement Banner for this Page",
        "type"  => "select",
        "std"   => "",
        "class" => "avia-style",
        "subtype" => array(
                            __("Disable",'avia_framework') => '',
                            __('Enable','avia_framework') => 'enabled',

                )
        );

	return $elements;
}
add_filter( 'avf_builder_elements', 'enfold_child_layout_elements', 10001, 1 );


/**
 * Set alternate header to all archive views
 */
function enfold_child_header_class( $class ) {
	// if ( is_archive() ) $class .= ' is-alternate';
    if( is_singular() ) {
		$post_id = get_the_ID();
		$banner_content = avia_get_option( 'announcement_banner' );

		if( (get_post_meta( $post_id, 'announcement_banner', true ) == 'enabled' ) && $banner_content ) {
			$class .= ' has-bar';
		}

	}
	return $class;
}
add_filter( 'avf_header_class_filter', 'enfold_child_header_class' );

/**
 * Disables Enfold Burger addition to nav
 */
if( !function_exists( 'avia_append_burger_menu' ) ) {
	add_filter( 'wp_nav_menu_items', 'avia_append_burger_menu', 9998, 2 );
	add_filter( 'avf_fallback_menu_items', 'avia_append_burger_menu', 9998, 2 );
	function avia_append_burger_menu ( $items , $args ) {
		return $items;
	}
}

/**
 * Disables Enfold Search addition to nav
 */
if( !function_exists( 'avia_append_search_nav' ) ) {
	add_filter( 'wp_nav_menu_items', 'avia_append_search_nav', 9997, 2 );
	add_filter( 'avf_fallback_menu_items', 'avia_append_search_nav', 9997, 2 );
	function avia_append_search_nav ( $items, $args ) {
	    return $items;
	}
}

/**
 * Disables Enfold Avia Title + Breadcrumbs
 */
if( !function_exists( 'avia_title' ) ) {
	function avia_title() {}
}

/**
 * Disables Enfold Post Navigation
 */
if( !function_exists( 'avia_post_nav' ) ) {
	function avia_post_nav() {}
}

/**
 * Disable Hide Featured Image Meta
 */
if( !function_exists( 'avia_add_hide_featured_image_select' ) ) {
	function avia_add_hide_featured_image_select() {}
}

/**
 * Returns a custom header size for scroll in view port, should match scrolled header size
 */
if( !function_exists( 'avia_get_header_scroll_offset' ) ) {
	function avia_get_header_scroll_offset( $header = array() ) {
		return 100;
	}
}

/**
 * Disable Image Sizes
 * This hook will disable Enfold image sizes
 */
function enfold_child_disable_image_sizes() {
	remove_image_size( 'masonry' );
	remove_image_size( 'magazine' );
	remove_image_size( 'widget' );
	remove_image_size( 'featured' );
	remove_image_size( 'featured_large' );
	remove_image_size( 'extra_large' );
	remove_image_size( 'portfolio' );
	remove_image_size( 'portfolio_small' );
	remove_image_size( 'gallery' );
	remove_image_size( 'entry_with_sidebar' );
	remove_image_size( 'entry_without_sidebar' );
	remove_image_size( 'square' );
}
add_action( 'after_setup_theme', 'enfold_child_disable_image_sizes', 11 );


/**
 * Default Icons Hook
 */
function enfold_child_default_icons( $icons ) {
	$icons['next'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
    $icons['prev'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
    $icons['next_big'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
    $icons['prev_big'] = array( 'font' => 'fa-fontello', 'icon' => 'ue800' );
	$icons['close'] = array( 'font' => 'fa-fontello', 'icon' => 'ue801' );

	return $icons;
}
add_filter( 'avf_default_icons', 'enfold_child_default_icons', 10, 1 );

/**
 * Replaces href value on Menu items linking to # in with javascript:void(0)
 */
function enfold_child_menu_items_replace_hash($menu_item) {
	if ( strpos( $menu_item, 'href="#"' ) !== false ) {
		$menu_item = str_replace( 'href="#"', 'href="javascript:void(0);"', $menu_item );
	}
	return $menu_item;
}
add_filter( 'walker_nav_menu_start_el', 'enfold_child_menu_items_replace_hash', 999 );

/**
 * Change Excerpt Length
 */
function enfold_custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'avf_excerpt_length', 'enfold_custom_excerpt_length', 999 );

/**
 * Change Excerpt Read More
 */
function enfold_new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'avf_excerpt_more', 'enfold_new_excerpt_more', 10, 1 );


/**
 * Enable ALB for All Post Types
 */
function enfold_child_enable_alb_for_cpts() {
	return array( 'portfolio', 'page', 'product', 'template_part' );
}
add_filter( 'avf_alb_supported_post_types', 'enfold_child_enable_alb_for_cpts' );

/**
 * Enable Gutenberg per post type
 */
function enfold_child_gutenberg( $new_use_block_editor, $use_block_editor, $post_type ) {
	$gutenberg_post_types = array( 'post','news-press','resources', 'webinar' );

	return in_array( $post_type, $gutenberg_post_types ) ? true : false;
}
add_filter( 'avf_can_use_block_editor_for_post_type', 'enfold_child_gutenberg', 100, 3 );

/**
 * Redirect Block
 */
function enfold_child_redirect_func() {

	if ( is_author() || is_date() ) {
		wp_redirect( home_url() );
		exit();
	}

	if( is_singular() ){
		if( function_exists( 'get_field' ) ) {
			if( get_field( "custom_link" ) ) {
				$redirect_to = get_field( "custom_link" );
				wp_redirect( $redirect_to );
				exit();
			}
		}
	}

}
add_filter( 'template_redirect', 'enfold_child_redirect_func' );

/**
 * Yoast SEO custom link exclusion
 */
function enfold_child_wpseo_exclude_from_sitemap() {

	$exclude_array = array();
	$domain = $_SERVER['SERVER_NAME'];

	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'any',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'     => 'custom_link',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => 'custom_link',
				'value'   => '',
				'compare' => '!=',
			),
		)
	);

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$this_post_id = get_the_ID();
			$custom_link = get_post_meta( $this_post_id, 'custom_link', true );

			if( strpos( $custom_link, $domain ) == false ){
				$exclude_array[] = get_the_ID();
			}
		}
	}

	wp_reset_postdata();
	return $exclude_array;

}
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'enfold_child_wpseo_exclude_from_sitemap' );


/**
 * Misc Hooks
 */
function enfold_child_upload_mimes( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['json'] = 'application/json';
	return $mimes;
}
add_filter( 'upload_mimes', 'enfold_child_upload_mimes' );

function enfold_child_wp_responsive_images() {
	return 1;
}
add_filter( 'max_srcset_image_width', 'enfold_child_wp_responsive_images' );


/**
 * Open Graphic Hooks
 */
add_filter( 'wpseo_json_ld_output', '__return_false' );

/**
 * Schema Pro hook to modify default Author field, replacing it with values from taxonomy 'post_author'
 */
function enfold_child_wp_schema_pro_article( $schema, $data, $post  ) {
	if( is_singular( 'post' ) ) {
		$post_id = get_the_ID();
		if( has_term( "", "post_author", $post_id ) ) {
			$schema['author'] = array();
			foreach ( get_the_terms( $post_id, "post_author" ) as $author ) {
				$author_id = $author->term_id;
				$schema['author'][] = array(
					"@type" => "Person",
					"name" => get_term_field( 'name', $author_id )
				);
			}
		}
	}
	return $schema;
}
add_filter( 'wp_schema_pro_schema_article', 'enfold_child_wp_schema_pro_article', 10, 3 );

/**
 * Yoast hook to modify default Byline author, replacing it with values from taxonomy 'post_author'
 */
function enfold_child_wpseo_enhanced_slack_data( $data, $presentation ) {
	if( is_singular( 'post' ) ) {
		$post_id = get_the_ID();
		if( has_term( "", "post_author", $post_id ) ) {
			$authors = array();
			foreach ( get_the_terms( $post_id, "post_author" ) as $author ) {
				$author_id = $author->term_id;
				$authors[] = get_term_field( 'name', $author_id );
			}
			$data[ \__( 'Written by', 'wordpress-seo' ) ] = implode( ", ", $authors );
		}
	}
	return $data;
}
add_filter( 'wpseo_enhanced_slack_data', 'enfold_child_wpseo_enhanced_slack_data', 10, 2 );

/**
 * Hook to add/modify Theme Options fields
 */
function enfold_child_option_page_data_init( $elements ){
	/**
	 * Announcement Bar Field adding to Theme Options
	 */
	$elements[] =	array(
		"name" 	=> __( "Announcement Banner", 'avia_framework' ),
		"id" 	=> "announcement_banner",
		"type" 	=> "text",
		"slug"	=> "avia"
  	);

	  $elements[] =	array(
		"name" 	=> __( "Announcement Banner Button Label", 'avia_framework' ),
		"id" 	=> "announcement_banner_label",
		"type" 	=> "text",
		"slug"	=> "avia"
  	);

	  $elements[] =	array(
		"name" 	=> __( "Announcement Banner Button Link", 'avia_framework' ),
		"id" 	=> "announcement_banner_link",
		"type" 	=> "text",
		"slug"	=> "avia"
  	);

	return $elements;
}
add_filter( 'avf_option_page_data_init', 'enfold_child_option_page_data_init' );
