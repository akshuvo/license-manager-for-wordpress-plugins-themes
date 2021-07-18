<?php

/**
 * The Menu handler class
 */
class LMFWPPT_LicenseHandler {

    /**
     * Initialize the class
     */
    function __construct() {
        
        add_action( 'wp_ajax_license_add_form', [ $this, 'license_add' ] );
        add_action( 'wp_ajax_package_id', [ $this, 'product_package' ] );
        add_action( 'wp_ajax_license_key', [ $this, 'license_key_add' ] );
        add_action( 'admin_init', [ $this, 'delete_license' ] );

        if ( isset( $_GET['license_key'] ) ) {
            $this->get_wp_license_details( sanitize_text_field( $_GET['license_key'] ) );
        }
        
    }

    // Get Product details by id al
    public static function get_license( $id = null ){

        if( !$id ){
            return;
        }

        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}lmfwppt_licenses WHERE id = %d", $id);
        return $wpdb->get_row( $query, ARRAY_A );
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

    // Product add form action
    function license_add(){
   
        if ( isset( $_POST['lmaction'] ) && $_POST['lmaction'] == "license_add_form" ) {

            $this->create_license( $_POST['lmfwppt'] );

        }

        die();
    }

    // Create License function
    function create_license( $post_data = array() ){
        global $wpdb;
        $table = $wpdb->prefix.'lmfwppt_licenses';
        $data = array(
            'license_key' => isset($post_data['license_key']) ? sanitize_text_field( $post_data['license_key'] ) : "",
            'package_id' => isset($post_data['package_id']) ? sanitize_text_field( $post_data['package_id'] ) : "",
            'order_id' => isset($post_data['order_id']) ? sanitize_text_field( $post_data['order_id'] ) : "",
            'end_date' => isset($post_data['end_date']) ? intval( $post_data['end_date'] ) : "",
        );

        if ( isset( $post_data['license_id'] ) ) {
            $insert_id = intval( $post_data['license_id'] );
            $wpdb->update( $table, $data, array( 'id'=> $insert_id ) );
        } else {
            $wpdb->insert( $table, $data);
            $insert_id = $wpdb->insert_id;
        }
        
        return $insert_id ? $insert_id : null;

    }

    // Select Package 
    function product_package() {

        if( isset( $_POST['id'] ) ) {

            $package_list = LMFWPPT_ProductsHandler::get_packages($_POST['id']);

            if( $package_list ) {

                foreach( $package_list as $result ):
                    $package_id = $result['package_id'];
                    $label = $result['label'];
                    ?>
                    <option value="<?php echo $package_id; ?>"><?php echo $label; ?></option> 
                    <?php 
                endforeach;
            }
         
        }
        die();
    }

    // License Key Genarate
    function license_key_add() {

        echo $key = rand();
        die();

    }

    // Delete License Id
    function lmfwppt_delete_license( $id ) {
        global $wpdb;

        return $wpdb->delete(
            $wpdb->prefix . 'lmfwppt_licenses',
            [ 'id' => $id ],
            [ '%d' ]
        );
    }

    // Get The Action
    function delete_license() {

        if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == "lmfwppt-delete-license" ){
            if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'lmfwppt-delete-license' ) ) {
                wp_die( 'Are you cheating?' );
            }

            if ( ! current_user_can( 'manage_options' ) ) {
                wp_die( 'Are you cheating?' );
            }

            $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0; 
            var_dump($id);

            if ( $this->lmfwppt_delete_license( $id ) ) {
                $redirected_to = admin_url( 'admin.php?page=license-manager-wppt-licenses&deleted=true' );
            } else {
                $redirected_to = admin_url( 'admin.php?page=license-manager-wppt-licenses&deleted=false' );
            }

            wp_redirect( $redirected_to );
            exit;

        }    
    } 

}

new LMFWPPT_LicenseHandler();
