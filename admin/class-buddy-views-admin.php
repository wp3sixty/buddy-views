<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/admin
 */

if ( ! class_exists( 'Buddy_Views_Admin' ) ) {
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
	class Buddy_Views_Admin {

		public function __construct(  ) {

		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		public function enqueue_styles() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Plugin_Name_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Plugin_Name_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_style( BUDDY_VIEWS_TEXT_DOMAIN, BUDDY_VIEWS_PATH . 'admin/css/buddy-views-public.css', array(), BUDDY_VIEWS_VERSION, 'all' );

		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		public function enqueue_scripts() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Plugin_Name_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Plugin_Name_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

			wp_enqueue_script( BUDDY_VIEWS_TEXT_DOMAIN, BUDDY_VIEWS_PATH . 'admin/js/buddy-views-public.js', array( 'jquery' ), BUDDY_VIEWS_VERSION, false );

		}

	}
}
