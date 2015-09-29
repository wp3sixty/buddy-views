<?php
/**
* Buddy Views Widget Functions
*
* Widget related functions and widget registration
*
* @author 		Mehul <mehul.kaklotar@gmail.com>
* @category 	Core
* @package 	BuddyViews/Functions
* @version     1.0.0
*/
if ( ! defined( 'ABSPATH' ) ) {
exit;
}

// Include widget classes
include_once( 'abstracts/abstract-buddy-views-widget.php' );
include_once( 'widgets/class-buddy-views-widget-top-viewed-members.php' );
/**
* Register Widgets
*
* @since 1.0.0
*/
function buddy_views_register_widgets() {
	register_widget( 'Buddy_Views_Widget_Top_Viewed_Members' );
}
add_action( 'widgets_init', 'buddy_views_register_widgets' );
