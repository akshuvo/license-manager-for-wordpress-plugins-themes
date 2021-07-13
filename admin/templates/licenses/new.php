<?php
$product_defaults_args = array (
    'license_key' => '',
    'product_type' => '',
    'product_list' => '',
    'order_id' => '',
    'package_id' => '',
    'end_date' => '',
);


$get_product = array();
$get_packages = null;

if ( isset( $_GET['action'] ) && $_GET['action'] == "edit" && isset( $_GET['id'] ) ) {
    $license_id = intval( $_GET['id'] );

    // Get Product date 
    $get_product = LMFWPPT_ProductsHandler::get_product( $license_id );

    // Get packages data
    $get_packages = LMFWPPT_ProductsHandler::get_packages( $license_id );

}

// Parse incoming $args into an array and merge it with $defaults
$get_product = wp_parse_args( $get_product, $product_defaults_args );
// Let's extract the array to variable
extract( $get_product );

?>
<div class="wrap">
    <h1><?php _e( 'New License', 'lmfwppt' ); ?></h1>

    <div class="lmwppt-wrap">
        <form action="" method="post" id="license-add-form">
            <div class="lmwppt-inner-card">
                <div class="lmfwppt-form-section" id="product-information">
                    <h2><?php esc_html_e( 'Product Information', 'lmfwppt' ); ?></h2>

                    <div class="lmfwppt-form-field">
                        <label for="download_link"><?php esc_html_e( 'License Key', 'lmfwppt' ); ?></label>
                        <div class="lmfwppt-file-field">
                            <input type="text" name="lmfwppt[license_key]" id="download_link" class="regular-text" placeholder="<?php esc_attr_e( 'License Key', 'lmfwppt' ); ?>" value="<?php echo esc_attr( $license_key ); ?>" readonly>
                            <button class="button" type="button" id="generate_key"><?php esc_html_e( 'Generate Key', 'lmfwppt' ); ?></button>
                        </div>
                    </div>

                    <div class="lmfwppt-form-field">
                        <label for="order_id"><?php esc_html_e( 'Order ID', 'lmfwppt' ); ?></label>
                        <select name="lmfwppt[order_id]" id="order_id">
                            <option value="1" <?php selected( $order_id, '1' ); ?> ><?php esc_html_e( '1', 'lmfwppt' ); ?></option>
                            <option value="2" <?php selected( $order_id, '2' ); ?> ><?php esc_html_e( '2', 'lmfwppt' ); ?></option>
                             <option value="3" <?php selected( $order_id, '3' ); ?> ><?php esc_html_e( '3', 'lmfwppt' ); ?></option>
                        </select>
                    </div>
                    <div class="lmfwppt-form-field">
                        <label for="product_type"><?php esc_html_e( 'Product Type', 'lmfwppt' ); ?></label>
                        <select name="lmfwppt[product_type]" id="product_type">

                            <option value=" " selected>Select Product Type</option>

                            <option value="Theme" <?php selected( $product_type, 'Theme' ); ?> ><?php esc_html_e( 'Theme', 'lmfwppt' ); ?></option>

                            <option value="Plugin" <?php selected( $product_type, 'Plugin' ); ?> ><?php esc_html_e( 'Plugin', 'lmfwppt' ); ?></option>
                        </select>
                    </div>
                    <!-- Theme Product List -->
                    <div class="lmfwppt-form-field" id="lmfwppt_theme_products">
                        <label for="product_theme_list"><?php esc_html_e( 'Theme Product List', 'lmfwppt' ); ?></label>
                        <select name="lmfwppt[product_theme_list]" id="product_theme_list">
                            <option value=" " selected>Select Product</option>
                            <option value="1" <?php selected( $product_list, 'Load More Anythings Theme' ); ?> ><?php esc_html_e( 'Load More Anythings Theme', 'lmfwppt' ); ?></option>
                        </select>
                    </div>
                    <!-- Theme License Package -->
                    <div class="lmfwppt-form-field" id="lmfwppt_theme_license_package">
                        <label for="lmfwppt_theme_package"><?php esc_html_e( 'Package Select', 'lmfwppt' ); ?></label>
                        <select name="lmfwppt[package_id]" id="lmfwppt_theme_package">
                            <option value="1 " <?php selected( $package_id, 'theme_license' ); ?> ><?php esc_html_e( 'Theme License 1', 'lmfwppt' ); ?></option>
                        </select>
                    </div>

                    <!-- Plugin Product List -->
                    <div class="lmfwppt-form-field" id="lmfwppt_plugin_products">
                        <label for="product_plugin_list"><?php esc_html_e( 'Plugin Product List', 'lmfwppt' ); ?></label>
                        <select name="lmfwppt[product_plugin_list]" id="product_plugin_list">
                            <option value=" " selected>Select Product</option>
                            <option value="1" <?php selected( $product_list, 'Load More Anythings Plugin' ); ?> ><?php esc_html_e( 'Load More Anythings Plugin', 'lmfwppt' ); ?></option>   
                        </select>
                    </div>

                    <!-- Plugin License Package -->
                    <div class="lmfwppt-form-field" id="lmfwppt_plugin_license_package">
                        <label for="lmfwppt_plugin_package"><?php esc_html_e( 'Package Select', 'lmfwppt' ); ?></label>
                        <select name="lmfwppt[package_id]" id="lmfwppt_plugin_package">
                            <option value="1 " <?php selected( $package_id, 'plugin_license' ); ?> ><?php esc_html_e( 'Plugin License 1', 'lmfwppt' ); ?></option>
                        </select>
                    </div>

                    <div class="lmfwppt-form-field">
                        <label for="end_date"><?php esc_html_e( 'License End Date', 'lmfwppt' ); ?></label>
                        <input type="number" name="lmfwppt[end_date]" id="end_date" class="regular-text product_name_input" placeholder="License End Date" value="<?php echo esc_attr( $end_date ); ?>" required>
                    </div>
                </div>
            </div>
          
            <div class="lmfwppt-buttons">
                <input type="hidden" name="lmaction" value="license_add_form">
                <input type="hidden" name="lmfwppt[created_by]" value="<?php _e( get_current_user_id() ); ?>">
                
                <?php if( isset( $license_id ) ) : ?>
                    <input type="hidden" name="lmfwppt[license_id]" value="<?php _e( $license_id ); ?>">
                <?php endif; ?>
                
                <?php wp_nonce_field( 'lmfwppt-add-product-nonce' ); ?>
                <?php submit_button( __( 'Add License', 'lmfwppt' ), 'primary', 'add_license' ); ?>
            </div>
        </form>

    </div>
<script type="text/javascript">
    (function($) {
        "use strict";

        function product_type() {
            var singleValues = $( "#product_type" ).val();
            var theme_license_id = $( "#product_theme_list" ).val();
            var plugin_license_id = $( "#product_plugin_list" ).val();
            $("div#lmfwppt_theme_products").hide();
            $("div#lmfwppt_plugin_products").hide();
            $("div#lmfwppt_theme_license_package").hide();
            $("div#lmfwppt_plugin_license_package").hide();
            if(singleValues == "Theme"){
                $("div#lmfwppt_theme_products").show();
                if(theme_license_id ==1){
                    $("div#lmfwppt_theme_license_package").show();
                }
            }
            else if(singleValues == "Plugin"){
                $("div#lmfwppt_plugin_products").show();
                if(plugin_license_id == 1){
                    $("div#lmfwppt_plugin_license_package").show();
                }
            }
        }
        $( "select" ).change( product_type );
        product_type();

    })(jQuery);
</script>
</div>

 