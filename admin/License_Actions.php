<?php

/**
 * License_Actions Handler class
 */
class License_Manager_WPPT_Actions {

    /**
     * Initialize the class
     */
    function __construct() {
        $this->add_form_handler();
    }

    /**
     * Handle the form
     *
     * @return void
     */
    public function add_form_handler() {
        if ( ! isset( $_POST['lmaction'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'new-address' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        global $wpdb;
        $table = $wpdb->prefix.'lmfwppt_products';
        $data = $_POST['lmfwppt'];

        $license_package = ( $data['license_package'] ) ? $data['license_package'] : array();
        $data['license_package'] = serialize($license_package);

        $data['created_at'] = date('Y-m-d H:i:s');

        $wpdb->insert( $table, $data );
        $insert_id = $wpdb->insert_id;

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        if ( $insert_id ) {
            $redirected_to = admin_url( 'admin.php?page=license-manager-wppt&action=edit&added=true&id=' . $insert_id );
        }

        wp_redirect( $redirected_to );
        exit;
    }

    public function delete_address() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-ac-delete-address' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        if ( wd_ac_delete_address( $id ) ) {
            $redirected_to = admin_url( 'admin.php?page=wedevs-academy&address-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=wedevs-academy&address-deleted=false' );
        }

        wp_redirect( $redirected_to );
        exit;
    }
}
new License_Manager_WPPT_Actions();