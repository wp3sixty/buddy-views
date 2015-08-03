<?php
/**
 * BuddyView Uninstall
 *
 * Uninstalling BuddyView deletes tables and user meta etc.
 *
 * @author      paresh
 * @category    Core
 * @package     BuddyView/Uninstaller
 * @version     1.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;


// Tables
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}bbv_profile_view_log" );

// Delete options
$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'buddyview\_%';" );
