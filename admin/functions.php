<?php

/**
 * Fetch Licenses
 *
 * @param  array  $args
 *
 * @return array
 */
function lmfwppt_get_licenses( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC'
    ];

    $args = wp_parse_args( $args, $defaults );

    $last_changed = wp_cache_get_last_changed( 'license' );
    $key          = md5( serialize( array_diff_assoc( $args, $defaults ) ) );
    $cache_key    = "all:$key:$last_changed";

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}license_manager
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
    );

    $items = wp_cache_get( $cache_key, 'license' );

    if ( false === $items ) {
        $items = $wpdb->get_results( $sql );

        wp_cache_set( $cache_key, $items, 'license' );
    }

    return $items;
}

/**
 * Get the count of total list
 *
 * @return int
 */
function lmfwppt_license_count() {
    global $wpdb;

    $count = wp_cache_get( 'count', 'license' );

    if ( false === $count ) {
        $count = (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}license_manager" );

        wp_cache_set( 'count', $count, 'license' );
    }

    return $count;
}

// Add license field ajax
add_action( 'wp_ajax_lmfwppt_single_license_field', 'lmfwppt_single_license_field_ajax_add_action' );
function lmfwppt_single_license_field_ajax_add_action(){

    $key = sanitize_text_field( $_POST['key'] );

    ob_start();

    echo lmfwppt_single_license_field( array(
        'key' => $key,
        'thiskey' => $key,
    ) );

    $output = ob_get_clean();

    echo $output;

    die();
}

// Single license field
function lmfwppt_single_license_field( $args ){

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
    $key =  isset( $args['key'] ) ? $args['key'] : "";

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
                                <label for="<?php esc_attr_e( $field_name ); ?>-support_period"><?php esc_html_e( 'Support Period', 'lmfwppt' ); ?></label>
                            </div>
                        </th>
                        <td>
                            <input id="<?php esc_attr_e( $field_name ); ?>-support_period" class="regular-text" type="number" min="1" name="<?php esc_attr_e( $field_name ); ?>[support_period]" value="<?php echo esc_attr( $support_period ); ?>" placeholder="<?php echo esc_attr( 'Enter in Days', 'lmfwppt' ); ?>" />
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
                            <input id="<?php esc_attr_e( $field_name ); ?>-domain_limit" class="regular-text" type="number" min="1" name="<?php esc_attr_e( $field_name ); ?>[domain_limit]" value="<?php echo esc_attr( $domain_limit ); ?>" placeholder="<?php echo esc_attr( 'How many domains allowed to get updates?', 'lmfwppt' ); ?>" />
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