<?php
/**
 * BuddyView Buddypress actions functions
 *
 * General buddypress action functions.
 *
 * @author        paresh
 * @category    Core
 * @package    BuddyView/Functions
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function bbv_record_view_log() {
	$displayed_user_id = bp_displayed_user_id();

	if ( $displayed_user_id != get_current_user_id() ) {



	}

}

add_action( 'bp_after_member_header', 'bbv_record_view_log' );