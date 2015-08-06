<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/admin/partials
 */

if ( ! class_exists( 'Buddy_Views_Integration' ) ) {
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
	class Buddy_Views_Integration {

		public function __construct() {
			Buddy_Views::$loader->add_action( 'bp_after_member_header', $this, 'record_view_log' );
		}

		/**
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		public function record_view_log() {
			$displayed_user_id = bp_displayed_user_id();

			if ( get_current_user_id() != $displayed_user_id ) {

			}

		}




	}
}


