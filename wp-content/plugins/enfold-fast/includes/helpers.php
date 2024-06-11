<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Helper function
 *
 * @package EnfoldFast
 */

class EnfoldFastHelpers {

    static public function lazy_load_js( $file, $echo = true ) {
		$lazy_string = "data-lazy='" . THEME_ASSETS . "js/" . $file . ".js'";
		
		if( $echo ){
			echo $lazy_string;
		} else {
			return $lazy_string;
		}
	}

    static public function lazy_load_css( $file, $echo = true ) {
		$lazy_string = "data-lazy-css='" . THEME_ASSETS . "css/" . $file . ".css'";
		
		if( $echo ){
			echo $lazy_string;
		} else {
			return $lazy_string;
		}
	}

}