<?php

add_action( 'admin_menu', 'taslim_admin_menu' );

function taslim_admin_menu() {
    $parent_slug = 'tdbegraving';
    $twoparent_slug = 'tdcrematie';
    $capability = 'edit_posts';

    /** Top Menu **/
    add_menu_page( __( 'TD Begraving', 'teamdigital' ), __( 'TD Begraving', 'teamdigital' ), $capability, $parent_slug, 'taslim_plugin_page', 'dashicons-plugins-checked', 2 );

    add_submenu_page( $parent_slug, __( 'City list', 'teamdigital' ), __( 'City list', 'teamdigital' ), $capability, 'td_city', 'taslim_plugin_city' );

    add_submenu_page( $parent_slug, __( 'Kist', 'teamdigital' ), __( 'Kist', 'teamdigital' ), $capability, 'td_kist', 'taslim_plugin_kist' );

    /** Top Menu **/
    add_menu_page( __( 'TD Crematie', 'teamdigital' ), __( 'TD Crematie', 'teamdigital' ), $capability, $twoparent_slug, 'td_cremation_plugin_page', 'dashicons-plugins-checked', 3 );

    //add_submenu_page( $twoparent_slug, __( 'TD Cremation', 'teamdigital' ), __( 'TD Cremation', 'teamdigital' ), $capability, 'td_cremation', 'td_cremation_plugin_page' );

    add_submenu_page( $twoparent_slug, __( 'City list', 'teamdigital' ), __( 'City list', 'teamdigital' ), $capability, 'td_ccity', 'taslim_plugin_ccity' );

    // add_submenu_page( $twoparent_slug, __( 'City list', 'teamdigital' ), __( 'City list', 'teamdigital' ), $capability, 'td_city', 'taslim_plugin_city' );
}

function taslim_plugin_page() {
    $action = isset( $_GET['action'] ) ? $_GET['action'] : '';
    $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    switch ( $action ) {
    case 'view':
        $template = dirname( __FILE__ ) . '/views/taslim-view.php';
        break;
    default:
        $template = dirname( __FILE__ ) . '/views/taslim-view.php';
        break;
    }

    if ( file_exists( $template ) ) {
        include $template;
    }
}

function td_cremation_plugin_page() {
    $action = isset( $_GET['action'] ) ? $_GET['action'] : '';
    $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    switch ( $action ) {
    case 'view':
        $template = dirname( __FILE__ ) . '/views/td-cremation-view.php';
        break;
    default:
        $template = dirname( __FILE__ ) . '/views/td-cremation-view.php';
        break;
    }

    if ( file_exists( $template ) ) {
        include $template;
    }
}

function taslim_plugin_ccity() {
    $action = isset( $_GET['action'] ) ? $_GET['action'] : '';
    $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    switch ( $action ) {
    case 'view':
        $template = dirname( __FILE__ ) . '/views/cctiy-list.php';
        break;
    default:
        $template = dirname( __FILE__ ) . '/views/cctiy-list.php';
        break;
    }

    if ( file_exists( $template ) ) {
        include $template;
    }
}

function taslim_plugin_city() {
    $action = isset( $_GET['action'] ) ? $_GET['action'] : '';
    $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    switch ( $action ) {
    case 'view':
        $template = dirname( __FILE__ ) . '/views/ctiy-list.php';
        break;
    default:
        $template = dirname( __FILE__ ) . '/views/ctiy-list.php';
        break;
    }

    if ( file_exists( $template ) ) {
        include $template;
    }
}

function taslim_plugin_kist() {
    $action = isset( $_GET['action'] ) ? $_GET['action'] : '';
    $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    switch ( $action ) {
    case 'view':
        $template = dirname( __FILE__ ) . '/views/kist-list.php';
        break;
    default:
        $template = dirname( __FILE__ ) . '/views/kist-list.php';
        break;
    }

    if ( file_exists( $template ) ) {
        include $template;
    }
}
