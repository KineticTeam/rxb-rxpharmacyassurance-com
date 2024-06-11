<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Attaches offset calc CSS based on Theme Options container to dynamic stylesheet
 */
function enfold_plus_dynamic_hook( $options, $color_set, $styles ){

	global $avia_config;

	if ( $options !== "" ){ extract( $options ); }
		
	if( empty( $responsive_size ) ) $responsive_size = "1130px"; // default container size
	
	$style_value = "";
	
	ob_start();
	?>

	#top .flex_column_table.offset-left>.flex_column:first-child {
		padding-left: calc( ( ( ( 100vw - var(--scrollBarWidth)) - <?php echo $responsive_size; ?>) / 2) + 50px) !important
	}

	@media only screen and (max-width: <?php echo $responsive_size; ?>) {
		#top .flex_column_table.offset-left>.flex_column:first-child {
			padding-left: calc( ( ( ( 100vw - var(--scrollBarWidth)) - 95%) / 2) + 50px) !important
		}
	}

	@media only screen and (max-width: 1024px) {
		#top .flex_column_table.offset-left>.flex_column:first-child {
			padding-left: 50px !important
		}
	}

	#top .flex_column_table.offset-right>.flex_column:last-child {
		padding-right: calc( ( ( ( 100vw - var(--scrollBarWidth)) - <?php echo $responsive_size; ?>) / 2) + 50px) !important
	}

	@media only screen and (max-width: <?php echo $responsive_size; ?>) {
		#top .flex_column_table.offset-right>.flex_column:last-child {
			padding-right: calc( ( ( ( 100vw - var(--scrollBarWidth)) - 95%) / 2) + 50px) !important
		}
	}

	@media only screen and (max-width: 1024px) {
		#top .flex_column_table.offset-right>.flex_column:last-child {
			padding-right: 50px !important
		}
	}

	@media only screen and (max-width: 989px) and (min-width: 768px) {
		#top .flex_column_table.av-break-at-tablet-flextable.offset-left:not(.offset-fwd-mobile),
		#top .flex_column_table.av-break-at-tablet-flextable.offset-right:not(.offset-fwd-mobile) {
			padding-right: 50px !important;
			padding-left: 50px !important
		}
		#top .flex_column_table.av-break-at-tablet-flextable.offset-left:not(.offset-fwd-mobile)>.flex_column:first-child,
		#top .flex_column_table.av-break-at-tablet-flextable.offset-left:not(.offset-fwd-mobile)>.flex_column:last-child,
		#top .flex_column_table.av-break-at-tablet-flextable.offset-right:not(.offset-fwd-mobile)>.flex_column:first-child,
		#top .flex_column_table.av-break-at-tablet-flextable.offset-right:not(.offset-fwd-mobile)>.flex_column:last-child {
			padding-right: 0 !important;
			padding-left: 0 !important
		}
	}

	@media only screen and (max-width: 989px) and (min-width: 768px) {
		#top .flex_column_table.av-break-at-tablet-flextable.offset-fwd-mobile.offset-left>.flex_column:first-child {
			padding-right: 50px !important;
			padding-left: 50px !important
		}
	}

	@media only screen and (max-width: 989px) and (min-width: 768px) {
		#top .flex_column_table.av-break-at-tablet-flextable.offset-fwd-mobile.offset-right>.flex_column:last-child {
			padding-right: 50px !important;
			padding-left: 50px !important
		}
	}

	@media only screen and (max-width: 989px) and (min-width: 768px) {
		#top .flex_column_table.av-break-at-tablet-flextable.offset-fwd-mobile.offset-left>.flex_column.av_one_full,
		#top .flex_column_table.av-break-at-tablet-flextable.offset-fwd-mobile.offset-right>.flex_column.av_one_full {
			padding-right: 0 !important;
			padding-left: 0 !important
		}
	}

	@media only screen and (max-width: 767px) {
		#top .flex_column_table.offset-left:not(.offset-fwd-mobile),
		#top .flex_column_table.offset-right:not(.offset-fwd-mobile) {
			padding-right: 7.5% !important;
			padding-left: 7.5% !important
		}
		#top .flex_column_table.offset-left:not(.offset-fwd-mobile)>.flex_column:first-child,
		#top .flex_column_table.offset-left:not(.offset-fwd-mobile)>.flex_column:last-child,
		#top .flex_column_table.offset-right:not(.offset-fwd-mobile)>.flex_column:first-child,
		#top .flex_column_table.offset-right:not(.offset-fwd-mobile)>.flex_column:last-child {
			padding-right: 0 !important;
			padding-left: 0 !important
		}
	}

	@media only screen and (max-width: 767px) {
		#top .flex_column_table.offset-left.offset-fwd-mobile>.flex_column:first-child {
			padding-right: 7.5% !important;
			padding-left: 7.5% !important
		}
	}

	@media only screen and (max-width: 767px) {
		#top .flex_column_table.offset-right.offset-fwd-mobile>.flex_column:last-child {
			padding-right: 7.5% !important;
			padding-left: 7.5% !important
		}
	}

	@media only screen and (max-width: 767px) {
		#top .flex_column_table.offset-left.offset-fwd-mobile>.flex_column.av_one_full,
		#top .flex_column_table.offset-right.offset-fwd-mobile>.flex_column.av_one_full {
			padding-right: 0 !important;
			padding-left: 0 !important
		}
	}

	<?php

	$style_value .= ob_get_clean();

	$avia_config['style'][] = array(
		'key'	=>	'direct_input',
		'value'	=>  $style_value
	);

}
add_action( 'ava_generate_styles', 'enfold_plus_dynamic_hook', 10, 3 );