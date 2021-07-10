<?php

/**
 * The Menu handler class
 */
class LMFWPPT_LicenseHandler {

    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'lmfwppt_license_field_after_wrap', [ $this, 'license_content' ], 10, 2 );
        
        // Add license field ajax
        add_action( 'wp_ajax_lmfwppt_single_license_field', [ $this, 'license_package_ajax_add_action' ] );

        // Product add action
        add_action( 'wp_ajax_product_add_form', [ $this, 'product_add' ] );
        //add_action( 'init', [ $this, 'product_add' ] );
    }

    // License Package Field add
    function license_package_ajax_add_action(){

        $key = sanitize_text_field( $_POST['key'] );

        ob_start();

        echo self::license_package_field( array(
            'key' => $key,
            'thiskey' => $key,
        ) );

        $output = ob_get_clean();

        echo $output;

        die();
    }

   
  

}

new LMFWPPT_LicenseHandler();