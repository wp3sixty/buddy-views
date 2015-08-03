<?php
/**
 * Installation related functions and actions.
 *
 * @author    paresh
 * @category  Admin
 * @package   BuddyViews/Classes
 * @version   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BBV_Install Class
 */
class BBV_Install {

	/** @var array DB updates that need to be run */
	private static $db_updates = array();

	/**
	 * Hook in tabs.
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'check_version' ), 5 );
		add_action( 'admin_init', array( __CLASS__, 'install_actions' ) );
		add_filter( 'wpmu_drop_tables', array( __CLASS__, 'wpmu_drop_tables' ) );
	}

	/**
	 * check_version function.
	 */
	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && ( get_option( 'buddyview_version' ) != BBV()->version ) ) {
			self::install();
			do_action( 'buddyview_updated' );
		}
	}

	/**
	 * Install actions such as installing pages when a button is clicked.
	 */
	public static function install_actions() {
		if ( ! empty( $_GET['do_update_buddyview'] ) ) {
			self::update();

			// What's new redirect
			delete_transient( '_bbv_activation_redirect' );
			exit;
		}
	}

	/**
	 * Install BBV
	 */
	public static function install() {

		if ( ! defined( 'BBV_INSTALLING' ) ) {
			define( 'BBV_INSTALLING', true );
		}

		// Ensure needed classes are loaded
		self::create_tables();

		// Queue upgrades/setup wizard
		//$current_bbv_version = get_option( 'buddyview_version', null );
		$current_db_version = get_option( 'buddyview_db_version', null );
		//$major_bbv_version   = substr( BBV()->version, 0, strrpos( BBV()->version, '.' ) );

		if ( ! is_null( $current_db_version ) && version_compare( $current_db_version, max( array_keys( self::$db_updates ) ), '<' ) ) {

		} else {
			self::update_db_version();
		}

		self::update_bbv_version();

		// Trigger action
		do_action( 'buddyview_installed' );
	}

	/**
	 * Update BBV version to current
	 */
	private static function update_bbv_version() {
		delete_option( 'buddyview_version' );
		add_option( 'buddyview_version', BBV()->version );
	}

	/**
	 * Update DB version to current
	 */
	private static function update_db_version( $version = null ) {
		delete_option( 'buddyview_db_version' );
		add_option( 'buddyview_db_version', is_null( $version ) ? BBV()->version : $version );
	}

	/**
	 * Handle updates
	 */
	private static function update() {
		$current_db_version = get_option( 'buddyview_db_version' );

		foreach ( self::$db_updates as $version => $updater ) {
			if ( version_compare( $current_db_version, $version, '<' ) ) {
				include( $updater );
				self::update_db_version( $version );
			}
		}

		self::update_db_version();
	}

	/**
	 * Set up the database tables which the plugin needs to function.
	 *
	 * Tables:
	 *        bbv_profile_view_log - Table for storing profile view logs
	 */
	private static function create_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		dbDelta( self::get_schema() );
	}

	/**
	 * Get Table schema
	 * @return string
	 */
	private static function get_schema() {
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		return "
CREATE TABLE {$wpdb->prefix}bbv_profile_view_log (
  view_id bigint(20) NOT NULL auto_increment,
  user_id bigint(20) NOT NULL,
  viwer_id bigint(20) NOT NULL,
  last_view datetime NULL default null,
  PRIMARY KEY  (view_id),
  KEY user_id (user_id),
  KEY last_view (last_view)
) $collate;
		";
	}

	/**
	 * Uninstall tables when MU blog is deleted.
	 *
	 * @param  array $tables
	 *
	 * @return array
	 */
	public static function wpmu_drop_tables( $tables ) {
		global $wpdb;

		$tables[] = $wpdb->prefix . 'bbv_profile_view_log';

		return $tables;
	}
}

BBV_Install::init();
