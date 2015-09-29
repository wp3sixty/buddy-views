<?php
/**
 * Don't load this file directly!
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Buddy_Views_Log_Model' ) ) {
	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    buddy-views
	 * @subpackage buddy-views/admin
	 * @author     Dipesh <dipesh.kakadiya111@gmail.com>
	 */
	class Buddy_Views_Log_Model extends RT_DB_Model {

		public function __construct() {
			parent::__construct( 'buddy_views_log' );
		}

		/**
		 * add view log entry
		 *
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		function add_view_log( $data ) {
			return parent::insert( $data );
		}

		/**
		 * update view log entry
		 *
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		function update_view_log( $data, $where ) {
			return parent::update( $data, $where );
		}

		/**
		 * Delete view log entry
		 *
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		function delete_view_log( $where ) {
			return parent::delete( $where );
		}


	}
}
