<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', 'enfold_plus_wp_head');
add_action( 'wp_enqueue_scripts', 'enfold_plus_styles' );
add_action( 'wp_enqueue_scripts', 'enfold_plus_scripts' );
add_action( 'admin_enqueue_scripts', 'enfold_plus_admin_styles' );
add_action( 'init', 'enfold_plus_template_part_register' );
add_filter( 'avf_alb_supported_post_types', 'enfold_plus_enable_alb_for_template_part', 10, 1 );
add_filter( 'avia_load_shortcodes', 'enfold_plus_shortcodes', 20, 1 );
add_filter( 'avf_default_shortcode_meta', 'enfold_plus_ep_style_sc_meta_setter', 10, 3 );
add_filter( 'avf_template_builder_shortcode_meta', 'enfold_plus_ep_style_sc_meta_modifier', 10, 4 );
add_filter( 'avf_ep_gmap_avia_api', 'enfold_plus_gmap_avia_api' );
add_filter( 'avf_custom_element_subtype_handling', 'enfold_plus_element_subtype_handling' );
add_action( 'load-post.php', 'enfold_plus_avia_script_replacement', 5 );
add_action( 'load-post-new.php', 'enfold_plus_avia_script_replacement', 5 );
add_filter( 'avf_vimeo_video_url', 'enfold_plus_vimeo_video_url', 10, 1 );

function enfold_plus_wp_head() {
	?>
	<script>document.addEventListener("DOMContentLoaded",function(){document.documentElement.style.setProperty("--scrollBarWidth",window.innerWidth-document.body.clientWidth+"px")});</script>
	<?php
}

function enfold_plus_styles() {
	wp_enqueue_style( 'avia-module-ep-shortcodes', ENFOLD_PLUS_ASSETS . 'css/ep_shortcodes.css', array( 'avia-scs' ), ENFOLD_PLUS_VERSION, 'all' );
}

function enfold_plus_scripts() {
	wp_enqueue_script( 'avia-module-ep-shortcodes-sc', ENFOLD_PLUS_ASSETS . 'js/ep_shortcodes.js', array( 'jquery' ), ENFOLD_PLUS_VERSION, true );
}

function enfold_plus_admin_styles() {
	wp_enqueue_style( 'ep-admin', ENFOLD_PLUS_ASSETS . 'css/ep_admin.css', array(), ENFOLD_PLUS_VERSION, 'all' );
}

function enfold_plus_avia_script_replacement() {

	$avia_builder_file = 'ep_avia-builder.js';

	wp_dequeue_script( 'avia_builder_js' );
	wp_enqueue_script( 'avia_builder_js', ENFOLD_PLUS_ASSETS . 'js/dist/admin/' . $avia_builder_file, array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'wp-color-picker', 'media-editor', 'post' ), ENFOLD_PLUS_VERSION );
}

/**
 * Loads Enfold Plus custom shortcodes
 */
function enfold_plus_shortcodes( $paths ) {
	array_unshift( $paths, ENFOLD_PLUS_AVIA_SC );
	return $paths;
}


/**
 * Sets ep_class in $meta
 */
function enfold_plus_ep_style_sc_meta_setter( $meta, $sc, $atts ) {
	$meta['ep_class'] = '';
	
	/**
	 * Row/column specific case
	 */
	if( strpos( get_class( $sc ), 'avia_sc_columns' ) !== false ) {
		$meta['row_class'] = '';
		$meta['ep_row_class'] = '';
	}

	return $meta;
}

/**
 * Modifies el_class if ep_style is present, passes value as class
 */
function enfold_plus_ep_style_sc_meta_modifier( $meta, $atts, $content, $shortcodename ) {
	if( ! empty( $atts['ep_style'] ) ) {
		$meta['el_class'] .= ' ' . $atts['ep_style'];
		$meta['ep_class'] = $atts['ep_style'];
	}

	if( ! empty( $atts['ep_extra_styles'] ) ) {
		$extra_styles = trim( str_replace( ',', ' ', $atts['ep_extra_styles'] ) );
		// Prevent repeating `ep_style` twice
		$extra_styles = str_replace( trim( $atts['ep_style'] ), '', $extra_styles );
		$meta['el_class'] .= ' ' . $extra_styles;
	}

	/**
	 * Row/column specific case
	 */
	if( ! empty( $atts['ep_row_style'] ) ) {
		$meta['row_class'] .= ' ' . $atts['ep_row_style'];
		$meta['ep_row_class'] = $atts['ep_row_style'];
	}

	if( ! empty( $atts['ep_extra_row_styles'] ) ) {
		$extra_row_styles = trim( str_replace( ',', ' ', $atts['ep_extra_row_styles'] ) );
		// Prevent repeating `ep_row_style` twice
		$extra_row_styles = str_replace( trim( $atts['ep_row_style'] ), '', $extra_row_styles );
		$meta['row_class'] .= ' ' . $extra_row_styles;
	}

	return $meta;
}

/**
 * Overwrites subtitem Enfold template handling
 */
function enfold_plus_element_subtype_handling(){
	return 'individually';
}

/**
 * Register Template Part CPT
 */
function enfold_plus_template_part_register() {

	register_post_type( 'template_part', array(
		'labels'  => array(
			'name' => __( "Template Parts", "avia_framework" ),
			'singular_name'=> __( "Template Parts", "avia_framework" )
		),
		'public' => true,
		'menu_icon' => 'dashicons-layout',
		'has_archive' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' )
	) );

}

/**
 * Enable ALB for Template Part
 */
function enfold_plus_enable_alb_for_template_part( $post_types ) {
	$post_types[] = 'template_part';

	return $post_types;
}

/**
 * Columns for Template Part
 */
add_filter( 'manage_template_part_posts_columns', 'enfold_plus_set_custom_edit_template_part_columns' );
function enfold_plus_set_custom_edit_template_part_columns( $columns ) {

	unset( $columns['date'] );

    $columns['used_in'] = "Used in";
	$columns['copy_sc'] = "Copy shortcode";
	$columns['date'] = "Date";

    return $columns;
}

add_action( 'manage_template_part_posts_custom_column' , 'enfold_plus_custom_template_part_column', 10, 2 );
function enfold_plus_custom_template_part_column( $column, $post_id ) {
	if( $column == 'used_in' ){
		global $wpdb;
		$query = "SELECT ID, post_title, guid FROM " . $wpdb->posts . " WHERE post_content LIKE '%[ep_template_part link=\'" . $post_id . "\'%' AND post_type NOT IN ('revision') LIMIT 1000";
		$results = $wpdb->get_results( $query );

		foreach ( $results as $result ) { 
			echo '<a href="' . get_edit_post_link( $result->ID ) . '">' . $result->post_title . '</a><br>';
		}
	}
	
	if( $column == 'copy_sc' ) {
		echo "<input style='width:350px' type='text' disabled value='[ep_template_part link=\"{$post_id}\" do_shortcode=\"yes\"]'>";
	}
}


/**
 * Replaces Google Maps API js url
 */
function enfold_plus_gmap_avia_api( $url ){
	return ENFOLD_PLUS_ASSETS . 'js/dist/avia/avia_google_maps_api.js';
}


/**
 * Theme Styles setup
 */
function enfold_plus_setup_theme_styles() {
	
	if( defined( 'THEME_STYLES' ) ) {

		/* Simple foreach */
		foreach( THEME_STYLES as $theme_style ){
	
			/** TODO: add support for 'default' key value, avf_{$sc}_style_std */
			
			$sc_hook = $theme_style['sc'];

			/** Options */
			add_filter( "avf_{$sc_hook}_style_options", function( $options ) use ( $theme_style ) {
	
				$new_options = array();
	
				foreach( $theme_style['styles'] as $style ) {
					if (isset( $style['label'] ) ) {
						$new_options[$style['label']] = $style['class'];
					}
				}
	
				$options = array_merge( $options, $new_options );	
	
				return $options;
	
			}, 10, 1 );

			/** Additional classes */
			foreach( $theme_style['styles'] as $style ) {
				if( isset( $style['additional_classes'] ) ){
					add_filter( 'avf_template_builder_shortcode_meta', function( $meta, $atts, $content, $shortcodename ) use ( $style ) {							
						if( isset( $meta['ep_class'] ) && isset( $style['class'] ) && ( $meta['ep_class'] == $style['class'] ) ){
							$meta['el_class'] .= ' ' . $style['additional_classes'];
						}
						return $meta;
					}, 11, 4 );	
				}
			}
			
			/**
			 * TODO:
			 * Load custom templates for:
			 * Tab Slider (control, slide)
			 * Posts Tab Slider (control, slide)
			 * Item Grid (item)
			 * Content Slider (slide)
			 * Posts Grid (block)
			 * Posts Slider (block)
			 */
			
		}
	}
}
add_action( 'after_setup_theme', 'enfold_plus_setup_theme_styles' );

/**
 * This is a helper function to ease checking if a class exists in a given
 * class string.
 *
 * @var string $haystack A string of classes. e.g. `container foo bar`.
 * @var string|array $classes A string or array containing the classes to
 *                            search for.
 * @return bool `true` if ANY of the class or classes exist in `$haystack`.
 */
function enfold_plus_has_class( $haystack, $classes ) {
	if (! is_string( $haystack ) ) {
		throw new InvalidArgumentException( 'Unexpected type for $haystack, expected string, received: ' . gettype( $haystack ) );
	}

	$haystack = explode( ' ', trim( $haystack ) );

	// If we received a string, convert to array.
	if ( is_string( $classes ) ) {
		$classes = array( $classes );
	}

	if (! is_array( $classes ) ) {
		throw new InvalidArgumentException( 'Unexpected type for $classes, expected string or array, received: ' . gettype( $classes ) );
	}

	return count( array_intersect( $classes, $haystack ) ) > 0; 
}

function enfold_plus_vimeo_video_url( $url ) {
	$url .= '&muted=1&autoplay=1';
	return $url;
}
