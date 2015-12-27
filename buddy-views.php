<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/LittleMonks/buddy-views
 * @since             1.0.1
 * @package           buddy-views
 *
 * @wordpress-plugin
 * Plugin Name:       Buddy Views
 * Plugin URI:        https://github.com/LittleMonks/buddy-views
 * Description:       BuddyPress Profile Views
 * Version:           1.0.1
 * Author:            littlemonks
 * Author URI:        https://github.com/LittleMonks
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       buddy-views
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if( !defined( 'WPINC' ) ) {
    die;
}


if( !defined( 'BUDDY_VIEWS_VERSION' ) ) {
    define( 'BUDDY_VIEWS_VERSION', '1.0.1' );
}

if( !defined( 'BUDDY_VIEWS_PLUGIN_FILE' ) ) {
    define( 'BUDDY_VIEWS_PLUGIN_FILE', __FILE__ );
}

if( !defined( 'BUDDY_VIEWS_PATH' ) ) {
    define( 'BUDDY_VIEWS_PATH', plugin_dir_path( __FILE__ ) );
}

if( !defined( 'BUDDY_VIEWS_URL' ) ) {
    define( 'BUDDY_VIEWS_URL', plugin_dir_url( __FILE__ ) );
}

if( !defined( 'BUDDY_VIEWS_BASE_NAME' ) ) {
    define( 'BUDDY_VIEWS_BASE_NAME', plugin_basename( __FILE__ ) );
}

if( !defined( 'BUDDY_VIEWS_PATH_TEMPLATES' ) ) {
    define( 'BUDDY_VIEWS_PATH_TEMPLATES', plugin_dir_path( __FILE__ ) . 'public/templates/' );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 *
 * @since    1.0.0
 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
 */
function activate_plugin_name() {
    require_once BUDDY_VIEWS_PATH . 'includes/class-buddy-views-activator.php';
    Buddy_Views_Activator::activate();
}

register_activation_hook( BUDDY_VIEWS_PLUGIN_FILE, 'activate_plugin_name' );
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 *
 * @since    1.0.0
 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
 */
function deactivate_plugin_name() {
    require_once BUDDY_VIEWS_PATH . 'includes/class-buddy-views-deactivator.php';
    Buddy_Views_Deactivator::deactivate();
}

register_deactivation_hook( BUDDY_VIEWS_PLUGIN_FILE, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 *
 * @since    1.0.0
 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
 */
require BUDDY_VIEWS_PATH . 'includes/class-buddy-views.php';

require BUDDY_VIEWS_PATH . 'includes/lib/rt-lib.php';

/**
 * Includes reports
 */
include_once( 'includes/bv-view-report-functions.php' );
include_once( 'includes/class-bv-reports-loader.php' );
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
 */
function run_buddy_views() {
    $buddy_views = Buddy_Views::instance();
}

run_buddy_views();
