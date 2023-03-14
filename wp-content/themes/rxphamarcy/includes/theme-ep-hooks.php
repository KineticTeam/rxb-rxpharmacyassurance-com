<?php

/**
 * Featured Posts Queries
 * 1. Create a Posts Grid with a class 'featured-posts'
 * 2. Place another Posts Grid adjacent to this
 */
function enfold_child_post_grid_before( $post_type, $post_id, $meta ){
    if( strpos( $meta['custom_class'], 'featured-posts' ) !== false ){
	    $GLOBALS['excluded_posts'][] = $post_id;
    }    
}
add_action( 'ava_ep_post_grid_post_before', 'enfold_child_post_grid_before', 10, 3 );
add_action( 'ava_ep_post_slider_post_before', 'enfold_child_post_grid_before', 10, 3 );

function enfold_child_posts_query( $post_query, $meta ) {
    if( strpos( $meta['custom_class'], 'featured-posts' ) !== false ){
        $post_query["meta_query"] = array(
            "relation" => "and",
            array(
                "key" => "is_featured",
                "compare" => "EXISTS"
            ),
            array(
                "key" => "is_featured",
                "value" => "0",
                "compare" => "!="
            )
        );
    } else {
    	if( isset( $GLOBALS["excluded_posts"] ) ) $post_query["post__not_in"] = $GLOBALS["excluded_posts"]; // used for featured posts query
    }

	return $post_query;
}
add_filter( 'avf_ep_post_grid_query', 'enfold_child_posts_query', 10, 2 );
add_filter( 'avf_ep_post_slider_query', 'enfold_child_posts_query', 10, 2 );

/**
 * Used for experimental archive/search view Posts Grid rendering
 */
function enfold_child_posts_query_object( $query_object, $meta ) {

    if ( is_archive() || is_search() ) {
        global $wp_query;
        $query_object = $wp_query;
    }

    return $query_object;
}
add_filter( 'avf_ep_post_grid_query_object', 'enfold_child_posts_query_object', 10, 2 );


/**
 * Post vars filters
 */
function enfold_child_post_item_link( $post_link, $post_type, $post_id, $meta, $shortcode ) {
    $post_link = enfold_child_custom_link( $post_id )['link'];

	return $post_link;
}
add_filter( 'avf_ep_post_item_link', 'enfold_child_post_item_link', 10, 5 );

function enfold_child_post_item_link_attrs( $post_link_attrs, $post_type, $post_id, $meta, $shortcode ) {
    $post_link_attrs = enfold_child_custom_link( $post_id )['attrs'];

	return $post_link_attrs;
}
add_filter( 'avf_ep_post_item_link_attrs', 'enfold_child_post_item_link_attrs', 10, 5 );

function enfold_child_post_item_content( $post_content, $post_type, $post_id, $meta, $shortcode ) {
    /*
    if( $post_type == 'team' ) {
        $post_content = get_field( 'job_title' );
    }
    */

	return $post_content;
}
add_filter( 'avf_ep_post_item_content', 'enfold_child_post_item_content', 10, 5 );

function enfold_child_post_item_date( $post_date, $post_type, $post_id, $meta, $shortcode ) {
    $post_date = enfold_child_format_date( $post_id, $post_date );


    $pto = get_post_type_object( $post_type );

    if( strpos( $meta['custom_class'], 'featured-posts' ) !== false ){

        if( !($post_type == 'resources' )){

            $post_date .= '<span class="featured-term">Featured '.$pto->labels->singular_name.'</span>';

        }else{
            if( has_term( 'video', 'resource_type', $post_id )){

                $post_date .= '<span class="featured-term">Featured Video</span>';

            }else if( has_term( 'download', 'resource_type', $post_id )){
                
                $post_date .= '<span class="featured-term">Featured Download</span>';

            }
        }
        
    }
    
	return $post_date;
}
add_filter( 'avf_ep_post_item_date', 'enfold_child_post_item_date', 10, 5 );

function enfold_child_post_item_classes( $post_classes, $post_type, $post_id, $meta, $shortcode ){

    $taxonomy = '';

    switch ( $post_type ) {
        case 'post':
            $taxonomy = 'category';
        break;
        case 'resources':
            $taxonomy = 'resource_type';
        break;
        case 'post':
            $taxonomy = 'category';
        break;
    }

    if ( $post_type == 'post' ){
        $taxonomy = 'category';
    }

    if( has_term( '', $taxonomy, $post_id ) ){
        foreach( get_the_terms( $post_id, $taxonomy ) as $term ) {
            $post_classes[] = "category-{$term->slug}";
        }
    }

    if ( ! has_post_thumbnail( $post_id ) ){
        $post_classes[] = "fallback-image";
    }
    
    return $post_classes;
}
add_filter( 'avf_ep_post_item_classes', 'enfold_child_post_item_classes', 10, 5 );

function enfold_child_fallback_img( $post_image, $post_type, $post_id, $meta, $shortcode ){

    if ( ! has_post_thumbnail( $post_id ) ){
        
        $post_image = wp_get_attachment_image( 926, 'full', array( 'srcset' => '' ) );
        
    }

    return $post_image;
}
add_filter( 'avf_ep_post_item_image', 'enfold_child_fallback_img', 10, 5 );




/*
function enfold_child_post_item_content_length( $post_content_length, $post_type, $post_id, $meta, $shortcode ) {
	return $post_content_length;
}
add_filter( 'avf_ep_post_item_content_length', 'enfold_child_post_item_content_length', 10, 5 );

function enfold_child_post_item_vars( $post_vars, $post_type, $post_id, $meta, $shortcode ) {
	return $post_vars;
}
add_filter( 'avf_ep_post_item_vars', 'enfold_child_post_item_vars', 10, 5 );
*/