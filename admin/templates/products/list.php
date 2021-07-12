<?php 	 
$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : null;
if( $page == 'license-manager-wppt-themes' ){
	$product_type = 'theme';
} else {
 	$product_type = 'plugin';
}	

?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'License Manager: Plugins', 'lmfwppt' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=license-manager-wppt&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New License', 'lmfwppt' ); ?></a>

    <form action="" method="post">
    	<?php 
    		$table = new LMFWPPT_ProductsListTable();
    		$table->prepare_items($product_type);
    		$table->display();

    	?>
    </form>

</div>

