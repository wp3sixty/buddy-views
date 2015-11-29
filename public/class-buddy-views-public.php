<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/LittleMonks/buddy-views
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/public
 */
if( !class_exists( 'Buddy_Views_Public' ) ) {

    /**
     * The public-facing functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    buddy-views
     * @subpackage buddy-views/public
     * @author     Dipesh <dipesh.kakadiya111@gmail.com>
     */
    class Buddy_Views_Public {

        public function __construct() {
            global $bv_integration;
            $bv_integration = new Buddy_Views_Integration();
        }

        /**
         * Register the stylesheets for the public-facing side of the site.
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
            wp_enqueue_style( 'buddy-views', BUDDY_VIEWS_URL . 'public/css/buddy-views' . $suffix . '.css', array(), BUDDY_VIEWS_VERSION, 'all' );
        }

        /**
         * Register the stylesheets for the public-facing side of the site.
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
            wp_enqueue_script( 'buddy-views', BUDDY_VIEWS_URL . 'public/js/buddy-views' . $suffix . '.js', array( 'jquery' ), BUDDY_VIEWS_VERSION, false );
        }

    }

}
