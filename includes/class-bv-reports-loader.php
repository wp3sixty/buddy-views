<?php
/**
 * Don't load this file directly!
 */
if( !defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'BV_Reports_Loader' ) ) {

    class BV_Reports_Loader {

        /**
         * Supported Chart Types
         */
        var $chart_types;

        /**
         * Return singleton instance of class
         *
         * @return BV_Reports_Loader
         */
        public static function factory() {

            static $instance = false;
            if( !$instance ) {
                $instance = new self();
            }
            return $instance;
        }

        /**
         * Placeholder method
         */
        public function __construct() {

            $this->chart_types = array(
                'table' => array(
                    'label' => __( 'Table Chart', 'buddy-views' ),
                    'max_fields' => 0,
                ),
                'pie' => array(
                    'label' => __( 'Pie Chart', 'buddy-views' ),
                    'max_fields' => 1,
                ),
                'gauge' => array(
                    'label' => __( 'Gauge Chart', 'buddy-views' ),
                    'max_fields' => 1,
                ),
                'area' => array(
                    'label' => __( 'Area Chart', 'buddy-views' ),
                    'max_fields' => 1,
                ),
                'stepped_area' => array(
                    'label' => __( 'Stepped Area Chart', 'buddy-views' ),
                    'max_fields' => 1,
                ),
                'bar' => array(
                    'label' => __( 'Bar Chart', 'buddy-views' ),
                    'max_fields' => 1,
                ),
                'column' => array(
                    'label' => __( 'Column Chart', 'buddy-views' ),
                    'max_fields' => 1,
                ),
                'line' => array(
                    'label' => __( 'Line Chart', 'buddy-views' ),
                    'max_fields' => 1,
                ),
            );

            $this->enqueue_scripts();
        }

        /**
         * Enqueue google script
         */
        public function enqueue_scripts() {

            $protocol = is_ssl() ? 'https' : 'http';
            $google_charts_scr = $protocol . '://www.google.com/jsapi';
            if( !wp_script_is( 'rt-google-charts' ) ) {
                wp_enqueue_script( 'rt-google-charts', $google_charts_scr );
            }
        }

        /**
         * Load google chart basic settings
         */
        public function print_scripts() {

            $charts = $this->chart_types;
            $core_charts = array( 'pie', 'line', 'bar', 'column', 'area', 'stepped_area' );

            foreach( $charts as $key => $chart ) {
                if( in_array( $key, $core_charts ) ) {
                    unset( $charts[ $key ] );
                }
            }
            $packages = array_keys( $charts );
            $packages[] = 'corechart';
            ?>
            <script type="text/javascript">
                // Load the Visualization API and the piechart package.
                google.load( 'visualization', '1.0', { 'packages': <?php echo json_encode( $packages ); ?> } );
            </script>
            <?php
        }

    }

}