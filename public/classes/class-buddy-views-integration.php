<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/LittleMonks/buddy-views
 * @since      1.0.0
 *
 * @package    buddy-views
 * @subpackage buddy-views/admin/classes
 */
if( !class_exists( 'Buddy_Views_Integration' ) ) {

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
            Buddy_Views::$loader->add_action( 'bp_before_member_header_meta', $this, 'record_view_log', 10 );
            Buddy_Views::$loader->add_action( 'bp_before_member_header_meta', $this, 'show_view_counter', 20 );
            Buddy_Views::$loader->add_action( 'bp_actions', $this, 'profile_subnav_item' );
            Buddy_Views::$loader->add_action( 'bp_setup_globals', $this, 'setup_global' );
        }

        /**
         * Add bv_profile in global variable for notification callback
         */
        public function setup_global() {
            global $bp;
            $bp->bv_profile_view = new stdClass();
            $bp->bv_profile_view->id = 'bv_profile_view';
            $bp->bv_profile_view->slug = 'bv_profile_view';
            $bp->bv_profile_view->notification_callback = array( $this, 'view_profile_notification_format' ); //this is a function which gets notifications needs to render
            $bp->active_components[ $bp->bv_profile_view->id ] = $bp->bv_profile_view->id;
            do_action( 'bv_profile_view_setup_globals' );
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
            $current_user_id = get_current_user_id();
            $viewer_ip = buddy_views_get_user_ip();

            $where = array(
                'member_id' => $displayed_user_id,
                'viewer_id' => $current_user_id,
                'viewer_ip' => $viewer_ip,
            );

            $is_log_exists = $bv_views_log_model->get( $where, false, 1, 'last_view desc' );

            if( !empty( $is_log_exists ) ) {
                $timestamp = !empty( $is_log_exists[ 0 ]->last_view ) ? strtotime( $is_log_exists[ 0 ]->last_view ) : current_time( 'timestamp' );
                $already_viewed = buddy_views_compare_timestamp( $timestamp );
            }

            // Check for current user is not the same user as displayed user
            if( $current_user_id != $displayed_user_id && !$already_viewed ) {

                $data = array(
                    'member_id' => $displayed_user_id,
                    'viewer_id' => $current_user_id,
                    'viewer_ip' => $viewer_ip,
                );

                $bv_views_log_model->add_view_log( $data );
                $this->add_notification( array(
                    'user_id' => $displayed_user_id,
                    'item_id' => $current_user_id,
                    'secondary_item_id' => 0,
                    'component_name' => 'bv_profile_view',
                    'component_action' => 'profile_view',
                    'date_notified' => bp_core_current_time(),
                    'is_new' => 1,
                ) );
            }
        }

        /**
         * Add notification to bbpress
         * @param $args
         */
        public function add_notification( $args ) {
            $notification_id = bp_notifications_add_notification( $args );
        }

        /**
         * Render notification string.
         *
         * @param $action
         * @param $item_id
         * @param $secondary_item_id
         * @param $total_items
         * @param string $format
         *
         * @return mixed|void
         */
        public function view_profile_notification_format( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {

            switch( $action ) {
                case 'profile_view':
                    $user_viewed = $item_id;
                    $at_user_viewed_link = bp_core_get_userlink( $user_viewed, false, true );
                    $at_user_viewed_title = sprintf( __( '@%s Viewed', 'buddy-views' ), bp_get_loggedin_user_username() );
                    $amount = 'single';

                    if( ( int ) $total_items > 1 ) {
                        $text = sprintf( __( 'You have %1$d new profile view', 'buddy-views' ), ( int ) $total_items );
                        $amount = 'multiple';
                    } else {
                        $user_fullname = bp_core_get_user_displayname( $user_viewed );
                        $text = sprintf( __( '%1$s viewed your profile', 'buddy-views' ), $user_fullname );
                    }
                    break;
            }

            if( 'string' == $format ) {

                /**
                 * Filters the @viewed notification for the string format.
                 *
                 * This is a variable filter that is dependent on how many items
                 * need notified about. The two possible hooks are bp_activity_single_profile_view_notification
                 * or bp_activity_multiple_profile_view_notification.
                 *
                 * @param string $string HTML anchor tag for the mention.
                 * @param string $at_user_viewed_link The permalink for the mention.
                 * @param int $total_items How many items being notified about.
                 * @param int $user_viewed ID of the user who viewed.
                 */
                $return = apply_filters( 'bp_activity_' . $amount . '_profile_view_notification', '<a href="' . esc_url( $at_user_viewed_link ) . '" title="' . esc_attr( $at_user_viewed_title ) . '">' . esc_html( $text ) . '</a>', $at_user_viewed_link, ( int ) $total_items, $user_viewed );
            } else {

                /**
                 * Filters the @viewed notification for any non-string format.
                 *
                 * This is a variable filter that is dependent on how many items need notified about.
                 * The two possible hooks are bp_activity_single_profile_view_notification
                 * or bp_activity_multiple_profile_view_notification.
                 *
                 * @since 1.5.0
                 *
                 * @param array $array Array holding the content and permalink for the mention notification.
                 * @param string $at_user_viewed_link The permalink for the mention.
                 * @param int $total_items How many items being notified about.
                 * @param int $user_viewed ID of the user who viewed profile.
                 */
                $return = apply_filters( 'bp_activity_' . $amount . '_profile_view_notification', array(
                    'text' => $text,
                    'link' => $at_user_viewed_link
                    ), $at_user_viewed_link, ( int ) $total_items, $user_viewed );
            }

            /**
             * Fires right before returning the formatted activity notifications.
             *
             * @since 1.2.0
             *
             * @param string $action The type of activity item.
             * @param int $item_id The activity ID.
             * @param int $secondary_item_id @mention mentioner ID.
             * @param int $total_items Total amount of items to format.
             */
            do_action( 'profile_view_format_notifications', $action, $item_id, $secondary_item_id, $total_items );

            return $return;
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

            if( !empty( $views ) ) {
                $views_count = count( $views );
                ?><span
                    class="bv-view-count"><?php echo sprintf( _n( '%s view', '%s views', $views_count, 'buddy-views' ), $views_count ); ?></span><?php
            }
        }

        public function profile_subnav_item() {
            global $bp, $wp_admin_bar;



            $slug = buddypress()->profile->slug;

            // Determine user to use
            if( bp_displayed_user_domain() ) {
                $user_domain = bp_displayed_user_domain();
            } elseif( bp_loggedin_user_domain() ) {
                $user_domain = bp_loggedin_user_domain();
            } else {
                return;
            }

            $friends_link = trailingslashit( $user_domain . $slug );

            $subnav_args = array(
                'name' => _x( 'Profile View', 'Profile header sub menu', 'buddy-views' ),
                'slug' => 'my-profile-view',
                'parent_url' => $friends_link,
                'parent_slug' => $slug,
                'screen_function' => array( $this, 'xprofile_screen_profile_views' ),
            );

            bp_core_new_subnav_item( $subnav_args );

            if( is_object( $wp_admin_bar ) ) {

                $admin_nav = array(
                    'parent' => 'my-account-' . $bp->profile->id,
                    'id' => 'my-account-' . $bp->profile->id . '-my-profile-view',
                    'title' => _x( 'My profile views', 'My Account Friends menu sub nav', 'buddy-views' ),
                    'href' => trailingslashit( $friends_link . 'my-profile-view' ),
                );

                $wp_admin_bar->add_menu( $admin_nav );
            }
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


