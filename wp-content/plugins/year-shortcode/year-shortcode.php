<?php
/*
Plugin Name: Year Shortcode
Plugin URI: http://www.punchteam.com
Description: A shortcode to output the current year, usage: [year]
Version: 1.0
Author: Punchteam
Author URI: http://www.punchteam.com
*/


add_shortcode( 'year', 'punch_year');

function punch_year($attr) {
    return date("Y");
}