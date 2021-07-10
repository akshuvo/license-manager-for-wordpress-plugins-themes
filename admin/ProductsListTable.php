<?php 
namespace admin;
  

if( !class_exists('WP_List_Table') ){
	require_once ABSPATH .'wp-admin/includes/class-wp-list-table.php';
}


/**
 *  
 * Product List Table Class
 * 
*/


class ProductsListTable extends \WP_List_Table{

	function __construct(){
		parent::__construct([
			'singular' => "product",
			'plural'   => "products",
			'ajax'     => false
		]);
	}

	// number of column
	public function get_columns(){
		return [
			'cb'     => "<input type='checkbox'/>",
			'name'   => __('Name','Name'),
			'slug'   => __('Slug','Slug'),
			'dated'  => __('Date','Date')
		];
	}

	/**
     * Get sortable columns
     *
     * @return array
     */


	// pagination and sortable use this code
    function get_sortable_columns() {
        $sortable_columns = [
            'name'       => [ 'name', true ],
            'dated' => [ 'dated', true ],
        ];

        return $sortable_columns;
    }
    // pagination and sortable use this code


	protected function column_default($item, $column_name){
		switch ($column_name) {
			case 'value':
				# code...
				break;
			
			default:
				return isset($item->$column_name) ? $item->$column_name : '';
		}
	}

	// Default column Customize
	public function column_name($item){
		$actions = [];
		$actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=license-manager-wppt&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'license-manager-wppt' ), __( 'Edit', 'license-manager-wppt' ) );

        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-ac-delete-address&id=' . $item->id ), 'wd-ac-delete-address' ), $item->id, __( 'Delete', 'license-manager-wppt' ), __( 'Delete', 'license-manager-wppt' ) );

		return sprintf(
			'<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=license-manager-wppt&action=view&id' .$item->id), $item->name, $this->row_actions($actions)
		);
	}

	protected function column_cb($item){
		return sprintf(
			"<input name='product_id[]' type='checkbox' value='%d'/>", $item->id
		);
	}

	public function prepare_items(){

		$column = $this->get_columns();
		$hidden = [];
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = [$column, $hidden, $sortable];

		//  pagination and sortable
		$per_page     = 2;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;
        $args = [
            'number' => $per_page,
            'offset' => $offset,
        ];

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items = wp_product($args);

        // pagination and sortable

		$this->set_pagination_args([
			'total_items' =>product_count(),
            'per_page'    =>$per_page,
		]);
	}

}
