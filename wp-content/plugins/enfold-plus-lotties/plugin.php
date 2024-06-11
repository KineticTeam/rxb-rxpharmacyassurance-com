<?php
/**
 * Plugin Name: Enfold Plus - Lotties
 * Plugin URI:
 * Description: This plugin will enable Lottie elements for Enfold
 * Version:     1.2.9
 * Author:      Punchteam
 * Author URI:  https://punchteam.com/
 * Text Domain: avia_framework
 * GitHub URI: https://github.com/punchteam/enfold-plus-lotties/
 *
 * @package EnfoldPlus
 */

require plugin_dir_path( __FILE__ ) . 'includes/plugin-update-checker/plugin-update-checker.php';

$enfoldPlusLottiesUpdateChecker = Puc_v4p10_Factory::buildFromHeader(
	__FILE__,
	array(
		'slug'         => 'enfold-plus-lotties',
		'checkPeriod'  => 6
	)
);

$enfoldPlusLottiesUpdateChecker->setAuthentication('c8b63098e412a4c95108006dbf5b3a98dfe18681');
$enfoldPlusLottiesUpdateChecker->setBranch('main');

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'EnfoldPlusLotties' ) ) :

class EnfoldPlusLotties {
	
	private static $instance;

	private function __construct() {

		// do nothing if EDD is not activated
		if( ! class_exists( 'EnfoldPlus', false ) ) {
			return;
		}

	}

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof EnfoldPlusLotties ) ) {
			self::$instance = new EnfoldPlusLotties;
			self::$instance->setup_constants();
			self::$instance->includes();
		}

		return self::$instance;
	}

	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '1.2.9' );
	}

	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'avia_framework' ), '1.2.9' );
	}

	private function setup_constants() {

		if ( ! defined( 'ALLOW_UNFILTERED_UPLOADS' ) ) {
			define( 'ALLOW_UNFILTERED_UPLOADS', true );
		}

		if ( ! defined( 'ENFOLD_PLUS_LOTTIES_VERSION' ) ) {
			define( 'ENFOLD_PLUS_LOTTIES_VERSION', '1.2.9' );
		}

		if ( ! defined( 'ENFOLD_PLUS_LOTTIES_URL' ) ) {
			define( 'ENFOLD_PLUS_LOTTIES_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'ENFOLD_PLUS_LOTTIES_PATH' ) ) {
			define( 'ENFOLD_PLUS_LOTTIES_PATH', plugin_dir_path( __FILE__ ) );
		}

		if ( ! defined( 'ENFOLD_PLUS_LOTTIES_ASSETS' ) ) {
			define( 'ENFOLD_PLUS_LOTTIES_ASSETS', ENFOLD_PLUS_LOTTIES_URL . 'assets/' );
		}

		if ( ! defined( 'ENFOLD_PLUS_LOTTIES_INC' ) ) {
			define( 'ENFOLD_PLUS_LOTTIES_INC', ENFOLD_PLUS_LOTTIES_PATH . 'includes/' );
		}

		if ( ! defined( 'ENFOLD_PLUS_LOTTIES_AVIA_SC' ) ) {
			define( 'ENFOLD_PLUS_LOTTIES_AVIA_SC', ENFOLD_PLUS_LOTTIES_PATH .'includes/avia-shortcodes/' );
		}
	}

	private function includes() {

		require_once ENFOLD_PLUS_LOTTIES_INC . 'core.php';
		require_once ENFOLD_PLUS_LOTTIES_INC . 'fields.php';

	}


}

endif; // End if class_exists check.


function enfoldpluslotties() {
	return EnfoldPlusLotties::instance();
}

enfoldpluslotties();
