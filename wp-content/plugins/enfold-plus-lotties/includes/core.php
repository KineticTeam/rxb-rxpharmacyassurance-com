<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'enfold_plus_lotties_styles' );
add_action( 'wp_enqueue_scripts', 'enfold_plus_lotties_scripts' );
add_filter( 'avia_load_shortcodes', 'enfold_plus_lotties_shortcodes', 20, 1 );
add_action( 'init', 'enfold_plus_lotties_template_part_register' );
add_filter( 'upload_mimes', 'enfold_plus_lotties_upload_mimes' );

function enfold_plus_lotties_styles() {

}

function enfold_plus_lotties_scripts() {

}

/**
 * Loads Enfold Plus custom shortcodes
 */
function enfold_plus_lotties_shortcodes( $paths ) {
	array_unshift( $paths, ENFOLD_PLUS_LOTTIES_AVIA_SC );
	return $paths;
}

/**
 * Register Template Part CPT
 */
function enfold_plus_lotties_template_part_register() {
	register_post_type( 'lottie_animation', array(
		'labels'  => array(
			'name' => "Lotties",
			'singular_name'=> "Lottie"
		),
		'menu_icon' => 'dashicons-welcome-view-site',
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'supports' => array( 'title', 'custom-fields' )
	) );
}

function enfold_plus_lotties_upload_mimes( $mimes ) {
	$mimes['json'] = 'application/json';
	return $mimes;
}