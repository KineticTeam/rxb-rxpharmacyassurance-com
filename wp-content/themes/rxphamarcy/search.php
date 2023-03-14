<?php
	if ( !defined('ABSPATH') ){ die(); }
	
	global $avia_config;

	/*
	* get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	*/
	get_header();
	 

	do_action( 'ava_after_main_title' );

	$hero_thumb = wp_get_attachment_url( 314 );

?>

<div class="single-search-hero avia-section alternate_color avia-no-border-styling avia-full-contain avia-builder-el-0  el_before_av_section avia-builder-el-first container_wrap fullsize has-gradient-section before-cloud-section section-offset-hero" style="background-image: url('<?php echo $hero_thumb; ?>')">
    <div class='container'>
        <div class='content'>
		<?php
		global $wp_query;
		if( !empty( $wp_query->found_posts ) ) {
			if( $wp_query->found_posts > 1 )
			{
				$output =  "<span>".$wp_query->found_posts."</span><span> Results For </span><span class='results-type'>'".esc_attr( get_search_query() )."'</span>";
			}
			else
			{
				$output =  "<span>".$wp_query->found_posts."</span><span> Results For </span><span class='results-type'>'".esc_attr( get_search_query() )."'</span>";
			}
		} else {
			if( !empty( $_GET['s'] ) )
			{
				$output = "<span>No results for </span><span class='results-type'>'".esc_attr( get_search_query() )."'</span>";
			}
			else
			{
				$output = "";
			}
		}
		?>
		<h1 class='search-title'>Search</h1>
		<h4 class="search-form-label">If you do not see the desired result, please revise your search term.</h4>
		<div class="search-form-inner"><?php get_search_form();?></div>
		<h3 class='search-result'><?php echo $output; ?></h3>
		</div>
	</div>
</div>

<div class="single-search-content avia-section avia-no-border-styling container_wrap main_color fullsize has-clouds-top section-offset-content">
    <div class="container">
        <div class="content">
			<?php if ( have_posts() ) { ?>
				<div class="search-grid facetwp-template">
					<?php
					while ( have_posts() ) {
						the_post(); 
						$post_id = get_the_ID();
						$column_class = 'is-full-desktop';
						include( get_stylesheet_directory() . '/includes/loop-content-search.php' );
					}
					?>
				</div>
				<?php echo facetwp_display( 'facet', 'load_more' ); ?>
			<?php } ?>
		</div>
    </div>
</div>

<?php 
	get_footer();