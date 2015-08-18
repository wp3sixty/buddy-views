<?php
/**
 * Prepare chart
 */
function bv_prepare_view_chart( $user_id ) {
	global $wpdb;

	$data_source = array();
	$cols        = array(
		__( 'Date' ),
		__( 'Views' )

	);
	$rows        = array();


	$result = $wpdb->get_results( "SELECT COUNT(*) AS view_count, DATE(last_view) view_date FROM {$wpdb->prefix}rt_buddy_views_log WHERE member_id = {$user_id} GROUP BY DATE(last_view)" );

	foreach ( $result as $data ) {

		$view_date = new DateTime( $data->view_date );
		$rows[]    = array( $view_date->format( 'M-Y' ), (int) $data->view_count );
	}


	$data_source['cols'] = $cols;

	$data_source['rows'] = array_map( 'unserialize', array_unique( array_map( 'serialize', $rows ) ) );;

	$chart = array(
		'id'          => 1,
		'chart_type'  => 'line',
		'data_source' => $data_source,
		'dom_element' => 'bv_views_' . $user_id,
		'options'     => array(
			'pointSize' => '5',
		)
	);

	return apply_filters( 'bv_prepare_view_chart', $chart, $user_id );
}   