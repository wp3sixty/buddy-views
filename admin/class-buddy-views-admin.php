<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/LittleMonks/buddy-views
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/admin
 */
if( !class_exists( 'Buddy_Views_Admin' ) ) {

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

        public function __construct() {

            global $bv_install, $bv_views_log_model;
            $bv_install = new Buddy_Views_Install();
            $bv_views_log_model = new Buddy_Views_Log_Model();
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        public function enqueue_styles() {
            $suffix = ( defined( 'SCRIPT_DEBUG' ) && constant( 'SCRIPT_DEBUG' ) === true ) ? '' : '.min';

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
            wp_enqueue_style( 'buddy-views', BUDDY_VIEWS_PATH . 'admin/css/buddy-views-admin' . $suffix . '.css', array(), BUDDY_VIEWS_VERSION, 'all' );
        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         * @author   Dipesh <dipesh.kakadiya111@gmail.com>
         */
        public function enqueue_scripts() {
            $suffix = ( defined( 'SCRIPT_DEBUG' ) && constant( 'SCRIPT_DEBUG' ) === true ) ? '' : '.min';

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
            wp_enqueue_script( 'buddy-views', BUDDY_VIEWS_PATH . 'admin/js/buddy-views-admin' . $suffix . '.js', array( 'jquery' ), BUDDY_VIEWS_VERSION, false );
        }

    }

}
