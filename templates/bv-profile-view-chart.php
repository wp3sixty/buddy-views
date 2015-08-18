<?php
global $bv_reports, $profile_view_report;
$user_id = bp_displayed_user_id();

$bv_reports->print_scripts();

?>

	<div id="bv_views_<?php echo $user_id; ?>"></div>

<?php
$chart = bv_prepare_view_chart( $user_id );

if ( ! empty( $chart ) ) {
	$profile_view_report->render_chart( array( $chart ) );
}
