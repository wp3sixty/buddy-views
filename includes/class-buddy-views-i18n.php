<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/LittleMonks/buddy-views
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/includes
 */

if ( ! class_exists( 'Buddy_Views_i18n' ) ) {
	/**
	 * Define the internationalization functionality.
	 *
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 *
	 * @since      1.0.0
	 * @package    buddy-views
	 * @subpackage buddy-views/includes
	 * @author     Dipesh <dipesh.kakadiya111@gmail.com>
	 */
	class Buddy_Views_i18n {

		/**
		 * The domain specified for this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string $domain The domain identifier for this plugin.
		 * @author     Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		private $domain;

		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since    1.0.0
		 * @author     Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain(
				$this->domain,
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);

		}

		/**
		 * Set the domain equal to that of the specified domain.
		 *
		 * @since    1.0.0
		 *
		 * @param    string $domain The domain that represents the locale of this plugin.
		 *
		 * @author     Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		public function set_domain( $domain ) {
			$this->domain = $domain;
		}

	}
}
