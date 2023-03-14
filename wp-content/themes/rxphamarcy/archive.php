<?php
	if ( !defined('ABSPATH') ){ die(); }
	
	global $avia_config;

	/*
	* get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	*/
	get_header();
	 
	$hero_title = is_author() ? get_queried_object()->user_nicename : get_queried_object()->name;

	do_action( 'ava_after_main_title' );
?>

<div class="avia-section alternate_color avia-section-huge avia-no-border-styling avia-builder-el-0 el_before_av_section avia-builder-el-first container_wrap fullsize">
	<div class="container">
		<div class="content">
			<h1><?php echo $hero_title; ?></h1>
		</div>
	</div>
</div>

<div class="avia-section main_color avia-section-default avia-no-border-styling container_wrap fullsize">
	<div class="container">
		<div class="content">
            <?php echo do_shortcode( '[ep_template_part link="1326" do_shortcode="yes"]' ); ?>
		</div>
	</div>
</div>

<?php 
	get_footer();
