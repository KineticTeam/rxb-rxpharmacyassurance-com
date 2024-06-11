<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function enfold_fast_shortcodes( $paths ) {
	array_unshift( $paths, ENFOLD_FAST_AVIA_SC );
	return $paths;
}
add_filter( 'avia_load_shortcodes', 'enfold_fast_shortcodes', 21, 1 );

function enfold_fast_option_page( $elements ){
  
	$elements[] =	array(
		"name" 	=> __( "Enable jQuery?", 'avia_framework' ),
		"id" 	=> "enfold_fast_enable_jquery",
		"type" 	=> "checkbox",
		"std"	=> "",
		"slug"	=> "performance"
  	);

	$elements[] =	array(
		"name" 	=> __( "Load avia-merge-styles CSS via script tag?", 'avia_framework' ),
		"desc"	=> __( "Enable if using WP Rocket Delay Script Execution setting + Optimize CSS Delivery", 'avia_framework' ),
		"id" 	=> "enfold_fast_avia_merged_styles",
		"type" 	=> "checkbox",
		"std"	=> "",
		"slug"	=> "performance"
  	);

	return $elements;
}
add_filter( 'avf_option_page_data_init', 'enfold_fast_option_page' );

function enfold_fast_default_iconfont( $iconfont ) {
	return array( 'fa-fontello' => 
		array(
			'append'	=> '',
			'include' 	=> ENFOLD_FAST_PATH . 'assets/fonts',
			'folder'  	=> ENFOLD_FAST_ASSETS . 'fonts',
			'config'	=> 'charmap.php',
			'compat'	=> 'charmap-compat.php',
			'full_path'	=> 'true'
		)
	);
}
add_filter( 'avf_default_iconfont', 'enfold_fast_default_iconfont', 10, 1 );

function enfold_fast_default_icons( $icons ) {
	$icons['twitter']	 = array( 'font' =>'fa-fontello', 'icon' => 'uf099');
	$icons['youtube']	 = array( 'font' =>'fa-fontello', 'icon' => 'uf16a');
	$icons['instagram']	 = array( 'font' =>'fa-fontello', 'icon' => 'uf16d');
	$icons['facebook']	 = array( 'font' =>'fa-fontello', 'icon' => 'uf308');
	$icons['linkedin']	 = array( 'font' =>'fa-fontello', 'icon' => 'uf30c');
	$icons['mail']	 = array( 'font' =>'fa-fontello', 'icon' => 'uf0e0');
	return $icons;
}
add_filter( 'avf_default_icons', 'enfold_fast_default_icons', 10, 1 );

function enfold_fast_scripts() {
	/** We de-register Enfold assets as we include our versions of it below */
	wp_deregister_style( 'avia-grid' );
	wp_deregister_style( 'avia-base' );
	wp_deregister_style( 'avia-layout' );
	wp_deregister_style( 'avia-scs' );
	wp_deregister_style( 'avia-lightbox' );
	wp_deregister_style( 'avia-popup-css' );

	wp_deregister_script( 'avia-compat' );
	wp_deregister_script( 'avia-default' );
	wp_deregister_script( 'avia-shortcodes' );
	wp_deregister_script( 'avia-waypoints' );
	wp_deregister_script( 'avia-popup-js' );

	/** Enfold Plus, to do, transform these to ES6/Babel */
	wp_deregister_style( 'avia-module-ep-bulma-grid' );
	wp_deregister_style( 'avia-module-ep-flickity' );
	wp_deregister_script( 'avia-module-ep-shortcodes-sc' ); // no action
	wp_deregister_script( 'avia-module-ep-flickity-slider' ); // done
	wp_deregister_script( 'avia-module-ep-item-grid' ); // transform to es6/babel
	wp_deregister_script( 'avia-module-ep-post-grid' ); // transform to fetch (hardest)

	/* Enfold Plus Flickity */
	wp_deregister_script( 'avia-module-ep-flickity' );
	wp_deregister_script( 'avia-module-ep-flickity-fade' );
	wp_deregister_script( 'avia-module-ep-enquire' );
	wp_deregister_script( 'avia-module-ep-flickity-sync' );
	wp_deregister_script( 'avia-module-ep-flickity-as-nav-for' );

	/* Enfold Plus Lotties */
	wp_deregister_script( 'avia-module-ep-lottie-web' );
	wp_deregister_script( 'avia-module-ep-lottie' );
	wp_deregister_script( 'avia-module-ep-lottie-slider' );

	/** Shortcodes */
	wp_deregister_style( 'avia-module-heading' );
	wp_deregister_style( 'avia-module-button' );
	wp_deregister_style( 'avia-module-buttonrow' );
	wp_deregister_style( 'avia-module-maps' );
	wp_deregister_style( 'avia-module-hr' );
	wp_deregister_style( 'avia-module-icon' );
	wp_deregister_style( 'avia-module-image' );
	wp_deregister_style( 'avia-module-social' );
	wp_deregister_style( 'avia-module-table' );
	wp_deregister_style( 'avia-module-slideshow' );

	/** Media Element JS */
	wp_deregister_script( 'wp-mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );
	
	/* Gmaps */
	wp_deregister_script( 'avia_google_maps_front_script' );
	
	/** get rid of jquery */
	if( avia_get_option( 'enfold_fast_enable_jquery' ) !== 'enfold_fast_enable_jquery' ) {
		if ( ! is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', false );
		}
	}

	/** dequeue dashicons */
	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}

	/** Enfold modules for sticky, mega not used */
	wp_deregister_script( 'avia-sticky-header' );
	wp_deregister_script( 'avia-megamenu' );
	
	/** Enfold assets not used */
	wp_dequeue_style( 'avia-custom' );
	wp_dequeue_style( 'avia-dynamic' );
	wp_dequeue_style( 'avia-style' );
	wp_dequeue_style( 'avia-widget-css' );
	wp_deregister_script( 'avia-widget-js' );

	/** Enqueue replacement assets (empty) */
	wp_enqueue_style( 'avia-grid', ENFOLD_FAST_ASSETS . 'css/dist/avia/grid.css', array(), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-base', ENFOLD_FAST_ASSETS . 'css/dist/avia/base.css', array( 'avia-grid' ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-layout', ENFOLD_FAST_ASSETS . 'css/dist/avia/layout.css', array( "avia-base" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-scs', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );

	wp_enqueue_style( 'avia-module-ep-bulma-grid', ENFOLD_FAST_ASSETS . 'css/dist/bulma-grid.css', array( 'avia-layout' ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-ep-flickity', ENFOLD_FAST_ASSETS . 'css/dist/flickity.css', array(), ENFOLD_FAST_VERSION, 'all' );

	/* Enequeue child scs */
	wp_enqueue_style( 'avia-module-heading', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/heading.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-button', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/buttons.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-buttonrow', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/buttonrow.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-hr', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/hr.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-icon', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/icon.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-image', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/image.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-social', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/social_share.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );
	wp_enqueue_style( 'avia-module-table', ENFOLD_FAST_ASSETS . 'css/dist/avia/shortcodes/table.css', array( "avia-layout" ), ENFOLD_FAST_VERSION, 'all' );

	wp_enqueue_script( 'avia-compat', ENFOLD_FAST_ASSETS . 'js/dist/avia/avia-compat.js' , array(), ENFOLD_FAST_VERSION, false );
	wp_enqueue_script( 'avia-module-enfold-fast-lazy-enabler', ENFOLD_FAST_ASSETS . 'js/dist/lazy-enabler.js', array(), ENFOLD_FAST_VERSION, true );
	wp_enqueue_script( 'avia-module-enfold-fast-lazy', ENFOLD_FAST_ASSETS . 'js/enfold-fast-lazy.js', array(), ENFOLD_FAST_VERSION, true );
	wp_enqueue_script( 'avia-module-enfold-fast', ENFOLD_FAST_ASSETS . 'js/enfold-fast.js', array(), ENFOLD_FAST_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'enfold_fast_scripts', 99 );

function enfold_fast_style_loader_tag( $tag, $handle, $href, $media ) {
	if( $handle == 'avia-merged-styles' && avia_get_option( 'enfold_fast_avia_merged_styles' ) == 'enfold_fast_avia_merged_styles' ) {
		$tag = "<script>document.write('<link rel=\"stylesheet\" href=\"{$href}\">');</script>\n";
	}
	return $tag;
}
add_filter( 'style_loader_tag', 'enfold_fast_style_loader_tag', 10, 4 );

function enfold_fast_header_assets() {
	/* WP Rocket rucss interaction, makes sure .ep-lottie-loaded opacity 1 rule is considered critical */
	if( class_exists( 'EnfoldPlusLotties', false ) ) {
		echo '<style>.ep-lottie-loaded{opacity:1!important}</style>';
	}
    ?>
	<noscript>
		<link rel="stylesheet" href="<?php echo ENFOLD_FAST_ASSETS; ?>css/dist/no-js.css?v=<?php echo ENFOLD_FAST_VERSION; ?>">
	</noscript>
    <?php
}
add_action( 'wp_head', 'enfold_fast_header_assets', 10 );


function enfold_fast_footer_assets() {
    ?>
	<script>document.write('<link rel="stylesheet" href="<?php echo ENFOLD_FAST_ASSETS; ?>css/body.css?v=<?php echo ENFOLD_FAST_VERSION; ?>">');</script>
    <?php
}
add_action( 'wp_footer', 'enfold_fast_footer_assets', 100 );

/**
 * EP Sliders init
 */
function enfold_fast_ep_sliders_init( $wrapper_data, $meta ) {
	$wrapper_data .= " data-lazy='" . ENFOLD_FAST_ASSETS . "js/dist/slider-combo.js' data-lazy-dep-obj='window.Flickity'";  

	return $wrapper_data;
}
add_filter( "avf_ep_content_slider_wrapper_data", "enfold_fast_ep_sliders_init", 10, 2 );
add_filter( "avf_ep_item_slider_wrapper_data", "enfold_fast_ep_sliders_init", 10, 2 ); // runs only if item grid is slider
add_filter( "avf_ep_posts_slider_wrapper_data", "enfold_fast_ep_sliders_init", 10, 2 );
add_filter( "avf_ep_tab_slider_wrapper_data", "enfold_fast_ep_sliders_init", 10, 2 );
add_filter( "avf_ep_posts_tab_slider_wrapper_data", "enfold_fast_ep_sliders_init", 10, 2 );
add_filter( "avf_ep_lottie_slider_wrapper_data", "enfold_fast_ep_sliders_init", 10, 2 );

/**
 * EP Lotties Init 
 */
function enfold_fast_ep_lotties_init( $wrapper_data_inner, $meta ) {
	$wrapper_data_inner .= " data-lazy='" . ENFOLD_FAST_ASSETS . "js/dist/lotties.js' data-lazy-dep='" . ENFOLD_FAST_ASSETS . "js/dist/lottie-web.js' data-lazy-dep-obj='window.bodymovin'";

	return $wrapper_data_inner;
}
add_filter( "avf_ep_lottie_wrapper_data", "enfold_fast_ep_lotties_init", 10, 2 );
add_filter( "avf_ep_lottie_slider_wrapper_data_inner", "enfold_fast_ep_lotties_init", 10, 2 );

/**
 * Theme Styles setup
 */
function enfold_fast_after_setup_theme() {

	/* Theme Supports */
	add_theme_support( "ep-disable-unused-heading" );
	add_theme_support( "ep-bg-lazy-load" );
	
	/* Theme Style Setup */
	if( defined( 'THEME_STYLES' ) ) {

		/* Simple foreach */
		foreach( THEME_STYLES as $theme_style ){
	
			/** TODO: add support for 'default' key value, avf_{$sc}_style_std */
			
			$sc_hook = $theme_style['sc'];
	
			/** Wrapper data */
			add_filter( "avf_{$sc_hook}_wrapper_data", function( $wrapper_data, $meta ) use ( $theme_style ) {
	
				/** TODO: Check strpos if wrapper_data already has lazy-css or lazy-js, if so, attach as an array rather, required epf lazy multiple support */
				foreach( $theme_style['styles'] as $style ) {

					$meta_key = $theme_style['sc'] == 'ep_row' ? 'ep_row_class' : 'ep_class';

					if( isset( $meta[$meta_key] ) && ( $meta[$meta_key] == $style['class'] ) ){
						if( isset( $style['lazy_css'] ) && $style['lazy_css'] ) {
							$lazy_load_css_string = is_bool( $style['lazy_css'] ) ? "shortcodes/{$style['class']}" : $style['lazy_css'];
							$wrapper_data .= EnfoldFastHelpers::lazy_load_css( $lazy_load_css_string, false );    
						}
						if( isset( $style['lazy_js'] ) && $style['lazy_js'] ) {
							$lazy_load_js_string = is_bool( $style['lazy_js'] ) ? "shortcodes/{$style['class']}" : $style['lazy_js'];
							$wrapper_data .= EnfoldFastHelpers::lazy_load_js( $lazy_load_js_string, false );    
						}
					}

				}
			
				return $wrapper_data;
	
			}, 10, 2 );

			
		}
	}
}
add_action( 'after_setup_theme', 'enfold_fast_after_setup_theme' );