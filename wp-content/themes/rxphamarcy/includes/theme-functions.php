<?php 

function custom_wp_is_mobile() {
	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
		$is_mobile = false;
	} elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) !== false // many mobile devices (all iPhone, iPad, etc.)
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Silk/' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Kindle' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false
	|| strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mobi' ) !== false ) {
		$is_mobile = true;
	} else {
		$is_mobile = false;
	}
	/**
	* Filters whether the request should be treated as coming from a mobile device or not.
	*
	* @since 4.9.0
	*
	* @param bool $is_mobile Whether the request is from a mobile device or not.
	*/
	return $is_mobile;
}

function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);
	
	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;
	
	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}
	
	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function hex2rgba($color, $opacity = false) {
	
	$default = 'rgb(0,0,0)';
	
	//Return default if no color provided
	if(empty($color))
	return $default; 
	
	//Sanitize $color if "#" is provided 
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	
	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}
	
	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);
	
	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
		$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}
	
	//Return rgb(a) color string
	return $output;
}

function enfold_child_format_date( $post_id, $post_date ){

	if( get_field( 'start_date', $post_id ) ) {
		$start_date = strtotime( get_field( 'start_date', $post_id ) );
		$end_date = strtotime( get_field( 'end_date', $post_id ) );
		
		if( $start_date !== $end_date ){
			
			$start_month = date( "F", $start_date );
			$end_month = date( "F", $end_date );
			
			if( $start_month == $end_month ){
				$post_date = date( "m", $start_date ) . "." . date( "d", $start_date ) . "." . date( "Y", $start_date ) . " - " . date( "m", $end_date ) . "." . date( "d", $end_date ) . "." . date( "Y", $end_date );
			} else {
				$post_date = date( "m", $start_date ) . "." . date( "d", $start_date ) . "." . date( "Y", $start_date ) . " - " . date( "m", $end_date ) . "." . date( "d", $end_date ) . "." . date( "Y", $end_date );
			}
			
		} else {
			$post_date = date( get_option( 'date_format' ), $start_date );
		}
	}
	
	return $post_date;
	
}

function enfold_child_custom_link( $post_id ){
	
	$custom_link_data = array();
	$custom_link_data['attrs'] = '';
	$custom_link_data['link'] = get_permalink( $post_id );
	
	if ( !empty ( get_field ( 'custom_link', $post_id ) ) ) {
		$custom_link_data['link'] = get_field( 'custom_link', $post_id );
		$domain = $_SERVER['SERVER_NAME'];
		if( strpos( $custom_link_data['link'], $domain ) == false ){
			$custom_link_data['attrs'] = 'target="_blank" rel="nofollow"';
		}
	} 
	
	return $custom_link_data;
}