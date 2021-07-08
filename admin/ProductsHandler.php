<?php

/**
 * The Menu handler class
 */
class LMFWPPT_ProductsHandler {

    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'lmfwppt_license_field_after_wrap', [ $this, 'license_content' ], 10, 2 );
        
        // Add license field ajax
        add_action( 'wp_ajax_lmfwppt_single_license_field', [ $this, 'license_package_ajax_add_action' ] );

        // Product add action
        add_action( 'init', [ $this, 'product_add' ] );
    }

    // License Package Field add
    function license_package_ajax_add_action(){

        $key = sanitize_text_field( $_POST['key'] );

        ob_start();

        echo $this->license_package_field( array(
            'key' => $key,
            'thiskey' => $key,
        ) );

        $output = ob_get_clean();

        echo $output;

        die();
    }

    // Single license field
    function license_package_field( $args ){

        $label = $support_period = $domain_limit = '';

        $defaults = array (
            'key' => '',
            'selector' => array(),
        );

        // Parse incoming $args into an array and merge it with $defaults
        $args = wp_parse_args( $args, $defaults );

        // Let's extract the array
        extract( $args['selector'] );

        // Array key
        //$key =  isset( $args['key'] ) ? $args['key'] : "";
        $key =  wp_generate_password( 3, false );;

        if ( !isset( $args['selector']['wrapper_title'] ) ) {
            $wrapper_title = __('Wrapper Title', 'lmfwppt');
        }

        // data_implement_selectors
        if ( !isset( $args['selector']['data_implement_selectors'] ) ) {
            $data_implement_selectors = array();
        }

        $field_name = "lmfwppt[license_package][$key]";


        ob_start();
        do_action( 'lmfwppt_license_field_before_wrap', $args );
        ?>

        <div id="postimagediv" class="postbox lmfwppt_license_field"> <!-- Wrapper Start -->
            <a class="header lmfwppt-toggle-head" data-toggle="collapse">
                <span id="poststuff">
                    <h2 class="hndle">
                        <input type="text" class="regular-text" name="<?php esc_attr_e( $field_name ); ?>[label]" placeholder="<?php esc_attr_e( 'License Title: 1yr unlimited domain.', 'lmfwppt' ); ?>" value="<?php esc_attr_e( $label ); ?>" title="<?php esc_attr_e( 'Change title to anything you like. Make sure they are unique.', 'lmfwppt' ); ?>">
                        <span class="dashicons indicator_field"></span>
                        <span class="delete_field">&times;</span>
                    </h2>
                </span>
            </a>
            <div class="collapse lmfwppt-toggle-wrap">
                <div class="inside">
                    <table class="form-table">

                        <tr valign="top">
                            <th scope="row">
                                <div class="tf-label">
                                    <label for="<?php esc_attr_e( $field_name ); ?>-package_id"><?php esc_html_e( 'Package ID', 'lmfwppt' ); ?></label>
                                </div>
                            </th>
                            <td>
                                <input id="<?php esc_attr_e( $field_name ); ?>-package_id" class="regular-text" type="text" name="<?php esc_attr_e( $field_name ); ?>[package_id]" value="<?php echo esc_attr( $package_id ); ?>" placeholder="<?php echo esc_attr( 'enter-package-id', 'lmfwppt' ); ?>" required />
                                <p><?php esc_html_e( 'Enter a unique url friendly text. No special characters allowed.', 'lmfwppt' ); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <div class="tf-label">
                                    <label for="<?php esc_attr_e( $field_name ); ?>-update_period"><?php esc_html_e( 'Update Period', 'lmfwppt' ); ?></label>
                                </div>
                            </th>
                            <td>
                                <input id="<?php esc_attr_e( $field_name ); ?>-update_period" class="regular-text" type="number" min="1" name="<?php esc_attr_e( $field_name ); ?>[update_period]" value="<?php echo esc_attr( $update_period ); ?>" placeholder="<?php echo esc_attr( 'Enter in Days', 'lmfwppt' ); ?>" required/>
                                <p><?php esc_html_e( 'Leave empty for lifetime updates.', 'lmfwppt' ); ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <div class="tf-label">
                                    <label for="<?php esc_attr_e( $field_name ); ?>-domain_limit"><?php esc_html_e( 'Domain Limit', 'lmfwppt' ); ?></label>
                                </div>
                            </th>
                            <td>
                                <input id="<?php esc_attr_e( $field_name ); ?>-domain_limit" class="regular-text" type="number" min="1" name="<?php esc_attr_e( $field_name ); ?>[domain_limit]" value="<?php echo esc_attr( $domain_limit ); ?>" placeholder="<?php echo esc_attr( 'How many domains allowed to get updates?', 'lmfwppt' ); ?>" required />
                                <p><?php esc_html_e( 'Leave empty for unlimited domain.', 'lmfwppt' ); ?></p>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        <!-- Wrapper end below -->
        </div>
        <?php
        $output = ob_get_clean();

        return do_action( 'lmfwppt_license_field_after_wrap', $output, $args );
    }
    
    // License Packages Content Render
    function license_content( $output, $args ){
        echo $output;
    }

    function product_add(){
        if ( isset( $_POST['lmaction'] ) && $_POST['lmaction'] == "product_add_form" ) {
            echo "<pre>";print_r($_POST);
            exit;
        }
    }

}

new LMFWPPT_ProductsHandler();