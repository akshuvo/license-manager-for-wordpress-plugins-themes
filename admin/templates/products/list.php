<div class="wrap">
	<?php 
	 
	 
		$value = $_GET['page'];

		// if($value == 'license-manager-wppt'){

		// }
	 
			
	?>
    <h1 class="wp-heading-inline"><?php _e( 'License Manager: Plugins', 'lmfwppt' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=license-manager-wppt&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New License', 'lmfwppt' ); ?></a>

    <form action="" method="post">
    	<?php 
    		$table = new LMFWPPT_ProductsListTable();
    		$table->prepare_items();
    		$table->display();

    	?>
    </form>

</div>

