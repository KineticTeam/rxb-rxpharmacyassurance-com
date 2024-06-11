<?php
/**
 * Plugin Name: Punch Core
 * Plugin URI:
 * Description: Punch Core
 * Version:     0.0.6
 * Author:      Punchteam
 * Author URI:  https://punchteam.com/
 * Text Domain: avia_framework
 * GitHub URI: https://github.com/punchteam/punch-core/
 *
 * @package PunchCore
 */

require plugin_dir_path( __FILE__ ) . 'includes/plugin-update-checker/plugin-update-checker.php';

$punchCoreUpdateChecker = Puc_v4p10_Factory::buildFromHeader(
	__FILE__,
	array(
		'slug'         => 'punch-core',
		'checkPeriod'  => 6
	)
);

$punchCoreUpdateChecker->setAuthentication('c8b63098e412a4c95108006dbf5b3a98dfe18681');
$punchCoreUpdateChecker->setBranch('main');

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'PunchCore' ) ) :

final class PunchCore {
	
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof PunchCore ) ) {
			self::$instance = new PunchCore;
			self::$instance->setup_constants();
			self::$instance->includes();
		}

		return self::$instance;
	}

	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '0.0.6' );
	}

	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '0.0.6' );
	}

	private function setup_constants() {

		if ( ! defined( 'PUNCH_CORE_VERSION' ) ) {
			define( 'PUNCH_CORE_VERSION', '0.0.6' );
		}

		if ( ! defined( 'PUNCH_CORE_URL' ) ) {
			define( 'PUNCH_CORE_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'PUNCH_CORE_PATH' ) ) {
			define( 'PUNCH_CORE_PATH', plugin_dir_path( __FILE__ ) );
		}

		if ( ! defined( 'PUNCH_CORE_ASSETS' ) ) {
			define( 'PUNCH_CORE_ASSETS', PUNCH_CORE_URL . 'assets/' );
		}

		if ( ! defined( 'PUNCH_CORE_INC' ) ) {
			define( 'PUNCH_CORE_INC', PUNCH_CORE_PATH . 'includes/' );
		}

	}

	private function includes() {

		require_once PUNCH_CORE_INC . 'core.php';
		
	}


}

endif; // End if class_exists check.


function PunchCore() {
	return PunchCore::instance();
}

PunchCore();
