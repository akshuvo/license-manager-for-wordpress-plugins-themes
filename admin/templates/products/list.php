<?php
global $wpdb;
$table = $wpdb->prefix.'lmfwppt_products';
$query  = "SELECT id,name FROM {$table}";
$products = $wpdb->get_results( $query, ARRAY_A );

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'License Manager: Plugins', 'lmfwppt' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=license-manager-wppt&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New License', 'lmfwppt' ); ?></a>

    <div class="lmfwppt-ul">
        <?php foreach ( $products as $key => $data ) : ?>
            <div class="lmfwppt-li">
                <a href="<?php echo admin_url( 'admin.php?page=license-manager-wppt' ); ?>&action=edit&id=<?php esc_attr_e( $data['id'] ); ?>"><h4><?php _e( $data['name'] ); ?></h4></a>
            </div>
        <?php endforeach;?>
    </div>
</div>
