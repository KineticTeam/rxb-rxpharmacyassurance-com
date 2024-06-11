<?php
/*
Plugin Name: Punch Sitemap
Plugin URI: http://www.punchteam.com
Description: Punch Sitemap Shortcode
Version: 1.0
Author: Punchteam
Author URI: http://www.punchteam.com
*/


add_shortcode( 'simple-sitemap', 'punch_sitemap_render_sitemap');

function punch_sitemap_render_sitemap($attr) {

	$args = shortcode_atts( array(
		'exclude' => '',
	), $attr );

	ob_start();

	?>
	<div class="punch-sitemap-wrapper simple-sitemap-wrap">
		<h3><?php echo __( 'Pages', 'punchteam' ); ?></h3>
		<ul>
		<?php
		wp_list_pages( array(
			'title_li' => null,
			'exclude' => $args['exclude'],
		) );
		?>
		</ul>
	</div>
	<style>
		.punch-sitemap-wrapper li{ padding: 8px 0; }
	</style>
	<?php

	return ob_get_clean();
}