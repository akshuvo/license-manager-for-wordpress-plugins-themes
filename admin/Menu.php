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
            [ $this, 'dashboard_page' ],
            'dashicons-tickets-alt'
        );

        add_submenu_page( $parent_slug, __( 'Plugins - License manager for WordPress Themes and Plugins', 'lmfwppt' ), __( 'Dashboard', 'lmfwppt' ), $capability, $parent_slug, [ $this, 'dashboard_page' ] );

        add_submenu_page( $parent_slug, __( 'Plugins - License manager for WordPress Themes and Plugins', 'lmfwppt' ), __( 'Plugins', 'lmfwppt' ), $capability, $parent_slug.'-plugins', [ $this, 'plugins_page' ] );

        add_submenu_page( $parent_slug, __( 'Themes - License manager for WordPress Themes and Plugins', 'lmfwppt' ), __( 'Themes', 'lmfwppt' ), $capability, $parent_slug.'-themes', [ $this, 'themes_page' ] );

        add_submenu_page( $parent_slug, __( 'License manager for WordPress Themes and Plugins', 'lmfwppt' ), __( 'Licenses', 'lmfwppt' ), $capability, $parent_slug.'-licenses', [ $this, 'licenses_page' ] );

        add_submenu_page( $parent_slug, __( 'Settings', 'lmfwppt' ), __( 'Settings', 'lmfwppt' ), $capability, 'lmfwppt-settings', [ $this, 'settings_page' ] );

        add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
    }

    /**
     * Handles Dashboard pages
     *
     * @return void
     */
    public function dashboard_page() {
        $template = __DIR__ . '/templates/dashboard/dashboard.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }
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
            case 'edit':
            case 'new':
                $template = __DIR__ . '/templates/products/new.php';
                break;

            default:
                $template = __DIR__ . '/templates/products/list.php';
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
            case 'edit':
            case 'new':
                $template = __DIR__ . '/templates/products/new.php';
                break;

            default:
                $template = __DIR__ . '/templates/products/list.php';
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
            case 'edit':
            case 'new':
                $template = __DIR__ . '/templates/licenses/new.php';
                break;

            default:
                $template = __DIR__ . '/templates/licenses/list.php';
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
        $template = __DIR__ . '/templates/settings/settings.php';
        
        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_media();
    }

}

new LMFWPPT_Menu();