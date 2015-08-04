<?php
/**
 * Plugin Name: Buddy View
 * Description: Buddypress profile view counters
 * Version: 1.0
 * Author: The Buddy View Contributors
 * Author URI: https://github.com/mehulkaklotar/buddy-views/graphs/contributors
 * Requires at least: 4.1
 * Tested up to: 4.2
 *
 * Text Domain: bbv
 * Domain Path: /i18n/languages/
 *
 * @package BuddyViews
 * @category Core
 * @author paresh
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'BuddyViews' ) ) :

	/**
	 * Main BuddyViews Class
	 *
	 * @class BuddyViews
	 * @version    1.0
	 */
	final class BuddyViews {

		/**
		 * @var string
		 */
		public $version = '1.0';

		/**
		 * @var BuddyViews The single instance of the class
		 * @since 2.1
		 */
		protected static $_instance = null;

		/**
		 * Main BuddyViews Instance
		 *
		 * Ensures only one instance of BuddyViews is loaded or can be loaded.
		 *
		 * @since 2.1
		 * @static
		 * @see WC()
		 * @return BuddyViews - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Cloning is forbidden.
		 * @since 2.1
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'bbv' ), '2.1' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 * @since 2.1
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'bbv' ), '2.1' );
		}

		/**
		 * BuddyViews Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'bbv_loaded' );
		}

		/**
		 * Hook into actions and filters
		 * @since 1.0
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, array( 'BBV_Install', 'install' ) );
		}

		/**
		 * Define WC Constants
		 */
		private function define_constants() {

			$this->define( 'BBV_PLUGIN_FILE', __FILE__ );
			$this->define( 'BBV_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'BBV_VERSION', $this->version );

		}

		/**
		 * Define constant if not already set
		 *
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 * string $type ajax, frontend or admin
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {

			include_once( 'includes/class-bbv-install.php' );

			if ( $this->is_request( 'admin' ) ) {
			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}
		}

		/**
		 * Include required frontend files.
		 */
		public function frontend_includes() {
		}


		/**
		 * Init BuddyViews when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_buddieview_init' );

			// Classes/actions loaded for the frontend and for ajax requests
			if ( $this->is_request( 'frontend' ) ) {
			}

			// Init action
			do_action( 'buddyview_init' );
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Get Ajax URL.
		 * @return string
		 */
		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}

	}

endif;

/**
 * Returns the main instance of WC to prevent the need to use globals.
 *
 * @since 1.0
 * @return BuddyViews
 */
function BBV() {
	return BuddyViews::instance();
}

// Global for backwards compatibility.
$GLOBALS['buddyview'] = BBV();