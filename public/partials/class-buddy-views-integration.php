<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/admin/partials
 */

if ( ! class_exists( 'Buddy_Views_Integration' ) ) {
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
	class Buddy_Views_Integration {

		public function __construct() {
			Buddy_Views::$loader->add_action( 'bp_after_member_header', $this, 'record_view_log' );
			Buddy_Views::$loader->add_action( 'bp_before_member_header_meta', $this, 'show_view_counter' );
			Buddy_Views::$loader->add_action( 'bp_actions', $this, 'profile_subnav_item' );
		}

		/**
		 * Record view log on profile visit
		 *
		 * @since    1.0.0
		 * @author   Dipesh <dipesh.kakadiya111@gmail.com>
		 */
		public function record_view_log() {

			global $bv_views_log_model;

			$already_viewed = false;

			$displayed_user_id = bp_displayed_user_id();
			$current_user_id   = get_current_user_id();
			$viewer_ip         = buddy_views_get_user_ip();

			$where = array(
				'member_id' => $displayed_user_id,
				'viewer_id' => $current_user_id,
				'viewer_ip' => $viewer_ip,
			);

			$is_log_exists = $bv_views_log_model->get( $where, false, 1, 'last_view desc' );

			if ( ! empty( $is_log_exists ) ) {
				$timestamp      = ! empty( $is_log_exists[0]->last_view ) ? strtotime( $is_log_exists[0]->last_view ) : current_time( 'timestamp' );
				$already_viewed = buddy_views_compare_timestamp( $timestamp );
			}

			// Check for current user is not the same user as displayed user
			if ( $current_user_id != $displayed_user_id && ! $already_viewed ) {

				$data = array(
					'member_id' => $displayed_user_id,
					'viewer_id' => $current_user_id,
					'viewer_ip' => $viewer_ip,
				);

				$bv_views_log_model->add_view_log( $data );
			}

		}

		/**
		 * Show view counter for member on member page
		 *
		 * @since    1.0.0
		 * @author   Mehul <mehul.kaklotar@gmail.com>
		 */
		public function show_view_counter() {

			global $bv_views_log_model;

			$displayed_user_id = bp_displayed_user_id();

			$where = array(
				'member_id' => $displayed_user_id,
			);

			$views = $bv_views_log_model->get( $where );

			if ( ! empty( $views ) ) {
				$views_count = count( $views );
				?><span
					class="bv-view-count"><?php echo sprintf( _n( '%s view', '%s views', $views_count, BUDDY_VIEWS_TEXT_DOMAIN ), $views_count ); ?></span><?php
			}
		}

		public function profile_subnav_item() {
			global $bp, $wp_admin_bar;;

			$slug = bp_get_profile_slug();

			// Determine user to use
			if ( bp_displayed_user_domain() ) {
				$user_domain = bp_displayed_user_domain();
			} elseif ( bp_loggedin_user_domain() ) {
				$user_domain = bp_loggedin_user_domain();
			} else {
				return;
			}

			$friends_link = trailingslashit( $user_domain . $slug );

			$subnav_args = array(
				'name'            => _x( 'Profile View', 'Profile header sub menu', 'bv' ),
				'slug'            => 'my-profile-view',
				'parent_url'      => $friends_link,
				'parent_slug'     => $slug,
				'screen_function' => array( $this, 'xprofile_screen_profile_views' )
			);


			$admin_nav = array(
				'parent' => 'my-account-' . $bp->profile->id,
				'id'     => 'my-account-' . $bp->profile->id . '-my-profile-view',
				'title'  => _x( 'My profile views', 'My Account Friends menu sub nav', 'bv' ),
				'href'   => trailingslashit( $friends_link . 'my-profile-view' )
			);


			bp_core_new_subnav_item( $subnav_args );

			$wp_admin_bar->add_menu( $admin_nav );
		}

		public function xprofile_screen_profile_views() {
			bp_core_load_template( apply_filters( 'xprofile_screen_profile_views', 'members/single/' ) );
			add_action( 'bp_template_content', array( $this, 'bp_profile_views_template_content' ) );
			global $bv_reports, $profile_view_report;


			$profile_view_report = new Rt_Reports( 'profile-view' );
			$bv_reports = BV_Reports_Loader::factory();

		}

		public function bp_profile_views_template_content() {
			include_once( BUDDY_VIEWS_PATH . '/templates/bv-profile-view-chart.php' );
		}

	}
}


