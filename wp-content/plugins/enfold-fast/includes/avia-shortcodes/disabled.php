<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$disabled_els = apply_filters( "avf_epf_disabled_elements", array(
    'audio-player',
    'blog',
    'buttons_fullwidth',
    'catalogue',
    'comments',
    'contact',
    'contentslider',
    'countdown',
    'gallery',
    'gallery_horizontal',
    'grid_row',
    'headline_rotator',
    'iconbox',
    'icongrid',
    'iconlist',
    'icon_circles',
    'image_hotspots',
    'magazine',
    'mailchimp',
    'masonry_entries',
    'masonry_gallery',
    'menu',
    'notification',
    'numbers',
    'partner_logo',
    'portfolio',
    'post_metadata',
    'postcontent',
    'postslider',
    'progressbar',
    'promobox',
    'search',
    'slideshow_accordion',
    'slideshow_feature_image',
    'slideshow_fullscreen',
    'slideshow_fullsize',
    'tab_section',
    'tabs',
    'team',
    'testimonial',
    'timeline',
    'toggles',
    'lottie_animation',
    'image_diff',
    'chart'
) );

foreach( $disabled_els as $disabled ){
    require_once( ENFOLD_FAST_INC . "avia-shortcodes-disabled/" . $disabled . ".php" );
}