<?php
/**
 * Plugin Name: License Manager for WordPress Plugins Themes
 * Plugin URI: https://github.com/akshuvo/license-manager-for-wordpress-plugins-themes
 * Github Plugin URI: https://github.com/akshuvo/license-manager-for-wordpress-plugins-themes
 * Description: Self-Hosted license manager for WordPress Plugins and Themes
 * Author: AddonMaster
 * Author URI: https://addonmaster.com
 * Version: 1.0.6
 * Text Domain: lmfwppt
 * Domain Path: /lang
 *
 */

/**
* Including Plugin file for security
* Include_once
*
* @since 1.0.0
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


define( 'LMFWPPT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LMFWPPT_PLUGIN_VERSION', '1.0' );

/**
 *	EDDNSTANT Functions
 */
//require_once( dirname( __FILE__ ) . '/inc/functions.php' );


/**
 *	Plugin Main Class
 */

final class LMFWPPT {

	private function __construct() {
		// Loaded textdomain
		add_action('plugins_loaded', array( $this, 'plugin_loaded_action' ), 10, 2);

		// Enqueue frontend scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 100 );

		// Added plugin action link
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );

		// trigger upon plugin activation/deactivation
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation' ) );

	}

	/**
	 * Initialization
	 */
	public static function init(){
     	static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
	}

	/**
	 * Adds plugin action links.
	 */
	function action_links( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=license-manager-wppt' ) . '">' . esc_html__( 'License Manager', 'lmfwppt' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}

	/**
	 * Plugin Loaded Action
	 */
	function plugin_loaded_action() {
		// Loading Text Domain for Internationalization
		load_plugin_textdomain( 'lmfwppt', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );

		require_once( dirname( __FILE__ ) . '/admin/functions.php' );
		require_once( dirname( __FILE__ ) . '/admin/Menu.php' );
		require_once( dirname( __FILE__ ) . '/admin/License_List.php' );

	}

	/**
	 * Enqueue Frontend Scripts
	 */
	function enqueue_scripts() {
		$ver = current_time( 'timestamp' );

	    wp_enqueue_style( 'lmfwppt-styles', LMFWPPT_PLUGIN_URL . 'assets/css/styles.css', null, $ver );
	    wp_enqueue_script( 'lmfwppt-scripts', LMFWPPT_PLUGIN_URL . 'assets/js/scripts.js', array('jquery'), $ver );

		wp_localize_script( 'lmfwppt-scripts', 'lmfwppt_params',
         	array(
         	    'nonce' => wp_create_nonce( 'lmwppt_nonce' ),
         	    'ajaxurl' => admin_url( 'admin-ajax.php' ),
         	)
         );

	}

	/**
	*  Plugin Activation
	*/
	function plugin_activation() {

        if ( ! get_option( 'lmfwppt_installed' ) ) {
            update_option( 'lmfwppt_installed', time() );
        }

        update_option( 'lmfwppt_plugin_version', LMFWPPT_PLUGIN_VERSION );

       	global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}license_manager` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL DEFAULT '',
          `product_type` varchar(30) DEFAULT NULL,
          `product_data` varchar(30) DEFAULT NULL,
          `licenses` varchar(30) DEFAULT NULL,
          `extras` varchar(30) DEFAULT NULL,
          `created_by` bigint(20) unsigned NOT NULL,
          `created_at` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
	}

	/**
	*  Plugin Deactivation
	*/
	function plugin_deactivation() {

	}

	/**
	 * Enqueue admin script
	 *
	 */
	function admin_scripts( $hook ) {
	    if ( 'options-permalink.php' != $hook ) {
	        //return;
	    }

	    $ver = current_time( 'timestamp' );

	    wp_enqueue_style( 'lmfwppt-admin-styles', LMFWPPT_PLUGIN_URL . 'admin/assets/css/admin.css', null, $ver );
	    wp_enqueue_script( 'lmwppt-admin-scripts', LMFWPPT_PLUGIN_URL . 'admin/assets/js/admin.js', array('jquery'), $ver );
	}

}


/**
 * Initialize plugin
 */
function lmfwppt(){
	return LMFWPPT::init();
}

// Let's start it
lmfwppt();
