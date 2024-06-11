<?php
/**
 * Plugin Name: Enfold Plus
 * Plugin URI:
 * Description: This plugin will add new and enhance Enfold elements.
 * Version:     0.1.9.61
 * Author:      Punchteam
 * Author URI:  https://punchteam.com/
 * Text Domain: avia_framework
 * GitHub URI: https://github.com/punchteam/enfold-plus/
 *
 * @package EnfoldPlus
 */

require plugin_dir_path( __FILE__ ) . 'includes/plugin-update-checker/plugin-update-checker.php';

$enfoldPlusUpdateChecker = Puc_v4p10_Factory::buildFromHeader(
	__FILE__,
	array(
		'slug'         => 'enfold-plus',
		'checkPeriod'  => 6
	)
);

$enfoldPlusUpdateChecker->setAuthentication('c8b63098e412a4c95108006dbf5b3a98dfe18681');
$enfoldPlusUpdateChecker->setBranch('main');

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'EnfoldPlus' ) ) :

final class EnfoldPlus {
	
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof EnfoldPlus ) ) {
			self::$instance = new EnfoldPlus;
			self::$instance->setup_constants();
			self::$instance->includes();
		}

		return self::$instance;
	}

	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '0.1.9.61' );
	}

	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '0.1.9.61' );
	}

	private function setup_constants() {

		if ( ! defined( 'ENFOLD_PLUS_VERSION' ) ) {
			define( 'ENFOLD_PLUS_VERSION', '0.1.9.61' );
		}

		if ( ! defined( 'ENFOLD_PLUS_URL' ) ) {
			define( 'ENFOLD_PLUS_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'ENFOLD_PLUS_PATH' ) ) {
			define( 'ENFOLD_PLUS_PATH', plugin_dir_path( __FILE__ ) );
		}

		if ( ! defined( 'ENFOLD_PLUS_ASSETS' ) ) {
			define( 'ENFOLD_PLUS_ASSETS', ENFOLD_PLUS_URL . 'assets/' );
		}

		if ( ! defined( 'ENFOLD_PLUS_INC' ) ) {
			define( 'ENFOLD_PLUS_INC', ENFOLD_PLUS_PATH . 'includes/' );
		}

		if ( ! defined( 'ENFOLD_PLUS_AVIA_SC' ) ) {
			define( 'ENFOLD_PLUS_AVIA_SC', ENFOLD_PLUS_PATH .'includes/avia-shortcodes/' );
		}
	}

	private function includes() {

		require_once ENFOLD_PLUS_INC . 'helpers.php';
		require_once ENFOLD_PLUS_INC . 'core.php';
		require_once ENFOLD_PLUS_INC . 'dynamic_css.php';
		require_once ENFOLD_PLUS_INC . 'dynamic_templates.php';
		
		/**
		 * Provided basic support in case child already wants to include class-gmaps (path should match), improve this into options page or add_theme_support or similar
		 */
		if( ! file_exists( get_stylesheet_directory() . '/includes/class-gmaps.php' ) ) require_once ENFOLD_PLUS_INC . 'class-gmaps.php';

	}


}

endif; // End if class_exists check.


function enfoldplus() {
	return EnfoldPlus::instance();
}

enfoldplus();
