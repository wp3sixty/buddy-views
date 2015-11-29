<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/LittleMonks/buddy-views
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/includes
 */
if( !class_exists( 'Buddy_Views' ) ) {

    /**
     * The core plugin class.
     *
     * This is used to define internationalization, admin-specific hooks, and
     * public-facing site hooks.
     *
     * Also maintains the unique identifier of this plugin as well as the current
     * version of the plugin.
     *
     * @since      1.0.0
     * @package    buddy-views
     * @subpackage buddy-views/includes
     * @author     Dipesh <dipesh.kakadiya111@gmail.com>
     */
    class Buddy_Views {

        /**
         * @var
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        private static $instance;

        /**
         * @var
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        public static $loader;

        /**
         * Create singleton object of Rtbiz
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         * @return    string    The name of the plugin.
         */
        public static function instance() {
            if( !isset( self::$instance ) && !( self::$instance instanceof Buddy_Views ) ) {
                self::$instance = new Buddy_Views();
                add_action( 'plugins_loaded', array( self::$instance, 'init_plugin' ) );
            }
            return self::$instance;
        }

        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         * @return void
         */
        public function __clone() {
            // Cloning instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'buddy-views' ), BUDDY_VIEWS_VERSION );
        }

        /**
         * Disable unserializing of the class
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         * @return void
         */
        public function __wakeup() {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'buddy-views' ), BUDDY_VIEWS_VERSION );
        }

        public function __construct() {

        }

        /**
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        public function init_plugin() {
            $this->load_dependencies();
            $this->set_locale();
            $this->define_admin_hooks();
            $this->define_public_hooks();

            $this->run();

            do_action( 'buddy_views_init' );
        }

        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
         * - Plugin_Name_i18n. Defines internationalization functionality.
         * - Plugin_Name_Admin. Defines all hooks for the admin area.
         * - Plugin_Name_Public. Defines all hooks for the public side of the site.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        private function load_dependencies() {

            /**
             * The class responsible for orchestrating the actions and filters of the
             * core plugin.
             */
            require_once BUDDY_VIEWS_PATH . 'includes/class-buddy-views-loader.php';

            /**
             * The class responsible for defining internationalization functionality
             * of the plugin.
             */
            require_once BUDDY_VIEWS_PATH . 'includes/class-buddy-views-i18n.php';

            /**
             * The class responsible for defining all actions that occur in the admin area.
             */
            require_once BUDDY_VIEWS_PATH . 'admin/class-buddy-views-admin.php';

            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */
            require_once BUDDY_VIEWS_PATH . 'public/class-buddy-views-public.php';

            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */
            require_once BUDDY_VIEWS_PATH . 'admin/helper/buddy-views-admin-helper.php';

            /**
             * This file responsible for defining all actions that occur in buddy views widgets
             */
            require_once BUDDY_VIEWS_PATH . 'admin/classes/buddy-views-widget-functions.php';

            new RT_WP_Autoload( BUDDY_VIEWS_PATH . 'admin/' );
            new RT_WP_Autoload( BUDDY_VIEWS_PATH . 'admin/classes/' );
            new RT_WP_Autoload( BUDDY_VIEWS_PATH . 'admin/classes/models/' );
            new RT_WP_Autoload( BUDDY_VIEWS_PATH . 'public/' );
            new RT_WP_Autoload( BUDDY_VIEWS_PATH . 'public/classes/' );



            self::$loader = new Buddy_Views_Loader();
        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
         * with WordPress.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        private function set_locale() {

            $plugin_i18n = new Buddy_Views_i18n();
            $plugin_i18n->set_domain( 'buddy-views' );
            $plugin_i18n->load_plugin_textdomain();
        }

        /**
         * Register all of the hooks related to the admin area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        private function define_admin_hooks() {

            $plugin_admin = new Buddy_Views_Admin( );

            self::$loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
            self::$loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        private function define_public_hooks() {

            $plugin_public = new Buddy_Views_Public( );

            self::$loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
            self::$loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        public function run() {
            self::$loader->run();
        }

    }

}
