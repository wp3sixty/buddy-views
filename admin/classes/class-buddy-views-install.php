<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/LittleMonks/buddy-views
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/admin/classes
 */

if ( ! class_exists( 'Buddy_Views_Install' ) ) {
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
	class Buddy_Views_Install {

		public function __construct() {
			Buddy_Views::$loader->add_action( 'admin_init', $this, 'database_update', 10, 0 );
		}

		/**
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		function database_update( ){
			$updateDB = new RT_DB_Update( trailingslashit( BUDDY_VIEWS_PATH ) . 'buddy-views.php', trailingslashit( BUDDY_VIEWS_PATH . 'admin/schema/' ) );
			$updateDB->do_upgrade();
		}

	}
}


