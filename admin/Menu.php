<?php

/**
 * The Menu handler class
 */
class LMFWPPT_Menu {

    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'license-manager-wppt';
        $capability = 'manage_options';

        $hook = add_menu_page(
            __( 'License manager for WordPress Themes and Plugins', 'lmfwppt' ),
            __( 'License manager', 'lmfwppt' ),
            $capability,
            $parent_slug,
            [ $this, 'plugins_page' ],
            'dashicons-tickets-alt'
        );

        add_submenu_page( $parent_slug, __( 'Plugins - License manager for WordPress Themes and Plugins', 'lmfwppt' ), __( 'Plugins', 'lmfwppt' ), $capability, $parent_slug, [ $this, 'plugins_page' ] );

        add_submenu_page( $parent_slug, __( 'Themes - License manager for WordPress Themes and Plugins', 'lmfwppt' ), __( 'Themes', 'lmfwppt' ), $capability, $parent_slug.'-themes', [ $this, 'themes_page' ] );

        add_submenu_page( $parent_slug, __( 'License manager for WordPress Themes and Plugins', 'lmfwppt' ), __( 'Licenses', 'lmfwppt' ), $capability, $parent_slug.'-licenses', [ $this, 'licenses_page' ] );

        add_submenu_page( $parent_slug, __( 'Settings', 'lmfwppt' ), __( 'Settings', 'lmfwppt' ), $capability, 'lmfwppt-settings', [ $this, 'settings_page' ] );

        add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
    }

    /**
     * Handles Plugin pages
     *
     * @return void
     */
    public function plugins_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/plugins/new.php';
                break;

            case 'edit':
                $address  = wd_ac_get_address( $id );
                $template = __DIR__ . '/views/plugins/edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/plugins/view.php';
                break;

            default:
                $template = __DIR__ . '/views/plugins/list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handles Theme pages
     *
     * @return void
     */
    public function themes_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/themes/new.php';
                break;

            case 'edit':
                $address  = wd_ac_get_address( $id );
                $template = __DIR__ . '/views/themes/edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/themes/view.php';
                break;

            default:
                $template = __DIR__ . '/views/themes/list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handles Theme pages
     *
     * @return void
     */
    public function licenses_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/licenses/new.php';
                break;

            case 'edit':
                $address  = wd_ac_get_address( $id );
                $template = __DIR__ . '/views/licenses/edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/licenses/view.php';
                break;

            default:
                $template = __DIR__ . '/views/licenses/list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handles the settings page
     *
     * @return void
     */
    public function settings_page() {
        echo 'Settings Page';
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        //wp_enqueue_style( 'academy-admin-style' );
        //wp_enqueue_script( 'academy-admin-script' );
    }
}

new LMFWPPT_Menu();