<?php

/**
 * Prepare chart
 */
function bv_prepare_view_chart( $user_id ) {
    global $wpdb;

    $data_source = array();
    $cols = array(
        __( 'Date', 'buddy-views' ),
        __( 'Views', 'buddy-views' )
    );
    $rows = array();

    $query = "SELECT COUNT(*) AS view_count, DATE(last_view) view_date FROM {$wpdb->prefix}rt_buddy_views_log WHERE member_id = {$user_id} AND DATE(last_view) >=  DATE(DATE_SUB(NOW(), INTERVAL 90 day)) GROUP BY DATE(last_view)";

    $result = $wpdb->get_results( $query );


    if( !empty( $result ) ) {
        foreach( $result as $data ) {

            $view_date = new DateTime( $data->view_date );
            $rows[] = array( $view_date->format( 'd-M-Y' ), ( int ) $data->view_count );
        }
    } else {
        $view_date = date( 'd-M-Y', strtotime( 'now -90 days' ) );
        $rows[] = array( $view_date, 0 );
        $view_date = new DateTime();
        $rows[] = array( $view_date->format( 'd-M-Y' ), 0 );
    }


    $data_source[ 'cols' ] = $cols;

    $data_source[ 'rows' ] = array_map( 'unserialize', array_unique( array_map( 'serialize', $rows ) ) );
    ;

    $chart = array(
        'id' => 1,
        'chart_type' => 'line',
        'data_source' => $data_source,
        'dom_element' => 'bv_views_' . $user_id,
        'options' => array(
            'pointSize' => '5',
            'interpolateNulls' => 'true'
        )
    );

    return apply_filters( 'bv_prepare_view_chart', $chart, $user_id );
}
