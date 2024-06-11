<?php
/**
 * Plugin Name: Enfold Fast
 * Plugin URI:
 * Description: This plugin will make Enfold faster.
 * Version:     1.2.30
 * Author:      Punchteam
 * Author URI:  https://punchteam.com/
 * Text Domain: avia_framework
 * GitHub URI: https://github.com/punchteam/enfold-fast/
 *
 * @package EnfoldFast
 */

require plugin_dir_path( __FILE__ ) . 'includes/plugin-update-checker/plugin-update-checker.php';

$enfoldFastUpdateChecker = Puc_v4p10_Factory::buildFromHeader(
	__FILE__,
	array(
		'slug'         => 'enfold-fast',
		'checkPeriod'  => 6
	)
);

$enfoldFastUpdateChecker->setAuthentication('c8b63098e412a4c95108006dbf5b3a98dfe18681');
$enfoldFastUpdateChecker->setBranch('main');

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'EnfoldFast' ) ) :

final class EnfoldFast {
	
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof EnfoldFast ) ) {
			self::$instance = new EnfoldFast;
			self::$instance->setup_constants();
			self::$instance->includes();
		}

		return self::$instance;
	}

	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '1.2.26' );
	}

	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '1.2.26' );
	}

	private function setup_constants() {

		if ( ! defined( 'ENFOLD_FAST_VERSION' ) ) {
			define( 'ENFOLD_FAST_VERSION', '1.2.26' );
		}

		if ( ! defined( 'ENFOLD_FAST_URL' ) ) {
			define( 'ENFOLD_FAST_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'ENFOLD_FAST_PATH' ) ) {
			define( 'ENFOLD_FAST_PATH', plugin_dir_path( __FILE__ ) );
		}

		if ( ! defined( 'ENFOLD_FAST_ASSETS' ) ) {
			define( 'ENFOLD_FAST_ASSETS', ENFOLD_FAST_URL . 'assets/' );
		}

		if ( ! defined( 'CHILD_THEME_ASSETS' ) ) {
			define( 'CHILD_THEME_ASSETS', get_stylesheet_directory_uri() . '/assets/' );
		}

		if ( ! defined( 'ENFOLD_FAST_INC' ) ) {
			define( 'ENFOLD_FAST_INC', ENFOLD_FAST_PATH . 'includes/' );
		}

		if ( ! defined( 'ENFOLD_FAST_AVIA_SC' ) ) {
			define( 'ENFOLD_FAST_AVIA_SC', ENFOLD_FAST_PATH .'includes/avia-shortcodes/' );
		}
	}

	private function includes() {

		require_once ENFOLD_FAST_INC . 'core.php';
		require_once ENFOLD_FAST_INC . 'helpers.php';

	}


}

endif; // End if class_exists check.


function enfoldfast() {
	return EnfoldFast::instance();
}

enfoldfast();
