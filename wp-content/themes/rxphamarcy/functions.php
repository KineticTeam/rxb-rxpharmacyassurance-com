<?php

/**
 * Site constants
 */
define( 'SITE_NAME', 'RX Pharmacy' );
define( 'SITE_SLUG', 'rx_pharmacy' );
define( 'REMOTE_URL', 'https://rxpharmacyassurance.com/' );
define( 'THEME_VERSION', '4.3.1' );
define( 'THEME_ENV', wp_get_environment_type() );
define( 'THEME_ASSETS', get_stylesheet_directory_uri() . '/assets/' );
define( 'THEME_INCLUDES', get_stylesheet_directory() . '/includes/' );

/**
 * Init Theme
*/
function enfold_child_setup() {
	add_theme_support( 'avia_template_builder_custom_post_type_grid' );
	add_theme_support( 'add_avia_builder_post_type_option' );
	add_theme_support( 'deactivate_layerslider' );

	remove_filter( 'the_title', 'wptexturize' );
	remove_filter( 'avia_ampersand', 'avia_ampersand' );
	remove_action( 'init', 'portfolio_register' );

	add_filter( 'kriesi_backlink', '__return_false' );

	update_option( 'image_default_size', 'full' );

	add_filter( 'wp_img_tag_add_srcset_and_sizes_attr', '__return_false' );

	/* Gutenberg */
	add_filter( 'avf_block_editor_theme_support', '__return_false' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	/* Gutenberg Block patterns */
	remove_theme_support( 'core-block-patterns' );
	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {

		register_block_pattern_category( SITE_SLUG, [
			'label' => SITE_NAME,
		] );

		register_block_pattern(
			SITE_SLUG . '/pattern-1',
			array(
				'title'       => __( 'Pattern 1', 'avia_framework' ),
				'content'     => "", // https://wpblockz.com/tool/tool-to-generate-code-for-your-wordpress-block-patterns/
				'categories'  => array( SITE_SLUG ),
			)
		);
  	}
}
add_action( 'after_setup_theme', 'enfold_child_setup', 51 );

/**
 * Enqueue scripts and styles.
 */
function enfold_child_scripts() {
	wp_enqueue_style( 'avia-module-main', THEME_ASSETS . 'css/main.css', array(), THEME_VERSION, 'all' );
	wp_enqueue_script( 'avia-module-main', THEME_ASSETS . 'js/main.js', array(), THEME_VERSION, true );
	wp_enqueue_style( 'googlefont', 'https://fonts.bunny.net/css?family=lato:300,300i,400,400i,700,700i|poppins:300,300i,400,400i,700,700i', array(), THEME_VERSION, 'all' );
	wp_enqueue_style( 'extrafont', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap', array(), THEME_VERSION, 'all' );
	wp_enqueue_style('app/gravity-forms', THEME_ASSETS . 'css/gravity-forms.css', [], THEME_VERSION);

	if ( is_single() ) {

		/* Common Single CSS */

		if( is_singular( array( 'post','news-press','resources', 'webinar' ) ) ) {
			wp_enqueue_style( 'theme-single-common', THEME_ASSETS . 'css/single-common.css', array(), THEME_VERSION, 'all' );
		}


		/* Specific Single CSS */
		/*
		if( is_singular( 'team' ) ) {
			wp_enqueue_style( 'theme-single-team', THEME_ASSETS . 'css/single-team.css', array(), THEME_VERSION, 'all' );
		}
		*/

		if( has_blocks() ) {
			/* Gutenberg CSS */
			wp_enqueue_style( 'theme-gutenberg', THEME_ASSETS . 'css/gutenberg.css', array(), THEME_VERSION, 'all' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'enfold_child_scripts', 100 );

function enfold_child_admin_scripts() {
	wp_enqueue_style( 'main-admin', THEME_ASSETS . 'css/dist/admin.css', array(), THEME_VERSION, 'all' );
}
add_action( 'admin_enqueue_scripts', 'enfold_child_admin_scripts', 100 );


function enfold_child_footer_assets() {
    ?>
    <link rel="stylesheet" href="<?php echo THEME_ASSETS; ?>css/body.css?v=<?php echo THEME_VERSION; ?>">
    <?php
}
add_action( 'wp_footer', 'enfold_child_footer_assets', 100 );

function enfold_child_ie_hook() {
	?>
	<script>
	if( window.MSInputMethodContext && document.documentMode ){
		document.write('<link rel="stylesheet" href="<?php echo THEME_ASSETS; ?>css/ie.css">');
	}
	</script>
	<?php
}
add_action( 'wp_head', 'enfold_child_ie_hook', 20, 1 );

require THEME_INCLUDES . 'theme-functions.php';
require THEME_INCLUDES . 'theme-shortcodes.php';
require THEME_INCLUDES . 'theme-hooks.php';
require THEME_INCLUDES . 'theme-ep-hooks.php';
require THEME_INCLUDES . 'tiny-mce.php';
