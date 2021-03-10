<?php
global $wpdb;
$table = $wpdb->prefix.'license_manager';
$query  = "SELECT id,name FROM {$table}";
$license_manager = $wpdb->get_results( $query, ARRAY_A );

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'License Manager: Plugins', 'lmfwppt' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=license-manager-wppt&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New License', 'lmfwppt' ); ?></a>

    <?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'License has been added successfully!', 'lmfwppt' ); ?></p>
        </div>
    <?php } ?>

    <?php if ( isset( $_GET['license-deleted'] ) && $_GET['license-deleted'] == 'true' ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'License has been deleted successfully!', 'lmfwppt' ); ?></p>
        </div>
    <?php } ?>

    <div class="lmfwppt-ul">
        <?php foreach ( $license_manager as $key => $data ) : ?>
            <div class="lmfwppt-li">
                <a href="<?php echo admin_url( 'admin.php?page=license-manager-wppt' ); ?>&action=edit&id=<?php esc_attr_e( $data['id'] ); ?>"><h4><?php _e( $data['name'] ); ?></h4></a>
            </div>
        <?php endforeach;?>
    </div>
</div>
