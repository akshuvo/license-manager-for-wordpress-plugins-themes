<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'License Manager', 'lmfwppt' ); ?></h1>

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

    <form action="" method="post">
        <?php
        $table = new License_Manager_WPPT_List();
        $table->prepare_items();
        $table->search_box( 'search', 'search_id' );
        $table->display();
        ?>
    </form>
</div>
