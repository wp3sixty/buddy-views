<?php
/**
 * Views log DB class
 *
 * This class is for interacting with the view logs' database table
 *
 * @package     BBV
 * @subpackage  Classes/DB Views
 * @author      parsh
 * @since       1.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * BBV_DB_Views Class
 *
 * @since 1.0
 */
class BBV_DB_Views extends BBV_DB {
	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   1.0
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name  = $wpdb->prefix . 'bbv_profile_view_log';
		$this->primary_key = 'view_id';
	}

	/**
	 * Add a view log
	 *
	 * @access  public
	 * @since   1.0
	 */
	public function add( $args ) {
		return $this->insert( $args, 'views' );
	}

}