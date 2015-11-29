<?php
if( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Top Rated Products Widget
 *
 * Gets and displays top rated products in an unordered list
 *
 * @author   Mehul <mehul.kaklotar@gmail.com>
 * @category Widgets
 * @package  BuddyViews/Widgets
 * @version  1.0.0
 * @extends  Buddy_Views_Widget
 */
class Buddy_Views_Widget_Top_Viewed_Members extends Buddy_Views_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        $this->widget_cssclass = 'buddy_views_widget_most_viewed_members';
        $this->widget_description = __( 'Display a list of your most viewed members on your site.', 'buddy-views' );
        $this->widget_id = 'buddy_views_most_viewed_members';
        $this->widget_name = __( 'Buddy Views Most Viewed Members', 'buddy-views' );
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __( 'Most Viewed Members', 'buddy-views' ),
                'label' => __( 'Title', 'buddy-views' ),
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __( 'Number of members to show', 'buddy-views' ),
            ),
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        if( $this->get_cached_widget( $args ) ) {
            return;
        }

        global $wpdb;

        ob_start();
        $number = !empty( $instance[ 'number' ] ) ? absint( $instance[ 'number' ] ) : $this->settings[ 'number' ][ 'std' ];

        $result = $wpdb->get_results( "SELECT count(*) AS member_count, member_id FROM {$wpdb->prefix}rt_buddy_views_log GROUP BY member_id ORDER BY member_count DESC LIMIT " . $number );

        if( !empty( $result ) ) {
            $this->widget_start( $args, $instance );
            echo '<ul id="members-list" class="item-list">';
            foreach( $result as $data ) {
                $member_id = $data->member_id;
                $views_count = $data->member_count;
                ?>
                <li class="vcard">
                    <div class="item-avatar">
                        <a href="<?php echo bp_core_get_user_domain( $member_id ); ?>" title="<?php echo bp_core_get_user_displayname( $member_id ); ?>"><?php echo get_avatar( $member_id, '32' ); ?></a>
                    </div>
                    <div class="item">
                        <div class="item-title fn"><a href="<?php echo bp_core_get_user_domain( $member_id ) ?>" title="<?php echo bp_core_get_user_displayname( $member_id ); ?>"><?php echo bp_core_get_user_displayname( $member_id ); ?></a></div>
                        <div class="item-meta">
                            <span class="activity"><?php echo sprintf( _n( '%s view', '%s views', $views_count, 'buddy-views' ), $views_count ); ?></span>
                        </div>
                    </div>
                </li>
                <?php
            }
            echo '</ul>';
            $this->widget_end( $args );
        }
        $content = ob_get_clean();
        echo $content;
        $this->cache_widget( $args, $content );
    }

}
