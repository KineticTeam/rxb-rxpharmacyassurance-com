<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function punch_core_scripts() {

	/* TODO: run if Enfold only */
	wp_enqueue_style( 'avia-module-offsets', PUNCH_CORE_ASSETS . 'css/offsets.css', array(), PUNCH_CORE_VERSION, 'all' );

	if ( is_single() ) {
		if( has_blocks() ) {
			/* Gutenberg CSS */
			wp_enqueue_style( 'punch-core-gutenberg', PUNCH_CORE_ASSETS . 'css/gutenberg.css', array(), PUNCH_CORE_VERSION, 'all' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'punch_core_scripts', 100 );

function punch_core_gutenberg_image_wrap( $block_content, $block ) {
	$image_with_align = "
/# 1) everything up to the class attribute contents
(
	^\s*
	<figure\b
	[^>]*
	\bclass=
	[\"']
)
# 2) the class attribute contents
(
	[^\"']*
	\bwp-block-image\b
	[^\"']*
	\b(?:alignleft|alignright|aligncenter)\b
	[^\"']*
)
# 3) everything after the class attribute contents
(
	[\"']
	[^>]*
	>
	.*
	<\/figure>
)/iUx";

	/*
	if (
		WP_Theme_JSON_Resolver::theme_has_support() ||
		0 === preg_match( $image_with_align, $block_content, $matches )
	) {
		return $block_content;
	}
	*/

	
	if( 0 === preg_match( $image_with_align, $block_content, $matches ) ) {
		return $block_content;
	}
		
	$wrapper_classnames = array( 'wp-block-image' );

	// If the block has a classNames attribute these classnames need to be removed from the content and added back
	// to the new wrapper div also.
	if ( ! empty( $block['attrs']['className'] ) ) {
		$wrapper_classnames = array_merge( $wrapper_classnames, explode( ' ', $block['attrs']['className'] ) );
	}
	$content_classnames          = explode( ' ', $matches[2] );
	$filtered_content_classnames = array_diff( $content_classnames, $wrapper_classnames );

	return '<div class="' . implode( ' ', $wrapper_classnames ) . '">' . $matches[1] . implode( ' ', $filtered_content_classnames ) . $matches[3] . '</div>';
}
add_filter( 'render_block_core/image', 'punch_core_gutenberg_image_wrap', 10, 2 );