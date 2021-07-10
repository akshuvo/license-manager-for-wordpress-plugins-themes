<?php

/**
 * The Menu handler class
 */
class LMFWPPT_LicenseHandler {

    /**
     * Initialize the class
     */
    function __construct() {
        
        //add_action( 'init', [ $this, 'get_license_details' ] );

        if ( isset( $_GET['license_key'] ) ) {
            $this->get_wp_license_details( sanitize_text_field( $_GET['license_key'] ) );
        }
        
    }

    // License Package Field add
    function get_license_details( $license_key = null ){
        $response = array();

        if ( !$license_key ) {
            return false;
        }

        global $wpdb;

        $get_license = $wpdb->get_row( $wpdb->prepare("SELECT package_id, dated FROM {$wpdb->prefix}lmfwppt_licenses WHERE license_key = %s", $license_key), ARRAY_A );

        $package_id = isset( $get_license['package_id'] ) ? $get_license['package_id'] : null;
        $license_date = isset( $get_license['dated'] ) ? $get_license['dated'] : null;

        if ( !$package_id ) {
            return false;
        }

        $get_product = $wpdb->get_row( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}lmfwppt_license_packages as lp INNER JOIN {$wpdb->prefix}lmfwppt_products as p ON p.id = lp.product_id WHERE lp.package_id = %s", $package_id), ARRAY_A );

        // change download url
        $get_product['license_key'] = $license_key;
        $get_product['license_date'] = $license_date;

        return $get_product;
    }


    // License Package Field add
    function get_wp_license_details( $license_key = null ){
        $response = array();

        if ( !$license_key ) {
            return false;
        }

        $download_link = add_query_arg( array(
            'license_key' => $license_key,
            'action' => 'download',
        ), lmfwppt_api_url() );

       $get_product = $this->get_license_details( $license_key );

        // change download url
        $get_product['download_link'] = $download_link;

        ppr($get_product);

        ppr($response);

        die();
    }

}

new LMFWPPT_LicenseHandler();