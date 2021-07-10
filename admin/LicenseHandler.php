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
            $this->get_license_details( sanitize_text_field( $_GET['license_key'] ) );
        }
        
    }

    // License Package Field add
    function get_license_details( $license_key = null ){
        if ( !$license_key ) {
            return false;
        }

        global $wpdb;

       
        $package_id = $wpdb->get_var( $wpdb->prepare("SELECT package_id FROM {$wpdb->prefix}lmfwppt_licenses WHERE license_key = %s", $license_key) );

        ppr( $package_id );

        die();
    }

}

new LMFWPPT_LicenseHandler();