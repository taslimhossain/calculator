<?php
/**
 * Insert a new City
 *
 * @param array $args
 */
function taslim_city_insert_City( $args = array(), $table = 'td_city' ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'name' => '',
        'postcode' => '',
        'burial_place' => '',
        'transport_price' => '',
        'zerotosixmaanden' => '',
        'sixtotwelvejaar' => '',
        'ouderdantwelve' => '',
        'meta_info' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . $table;

    // some basic validation

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        $args['created_at'] = current_time( 'mysql' );

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}


/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
        add_action( 'admin_init', array( $this, 'handle_kist_form' ) );
        add_action( 'admin_init', array( $this, 'taslim_delete_city' ) );
    }

    public function taslim_delete_city() {
        if ( ! isset( $_GET['city_deleteid'] ) ) {
            return;
        }
        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'teamdigital' ) );
        }
        $page_url = admin_url( 'admin.php?page=td_city' );
        $city_id = isset( $_GET['city_deleteid'] ) ? intval( $_GET['city_deleteid'] ) : 0;
        if ( taslim_city_delete( $city_id ) ) {
            $redirected_to = admin_url( 'admin.php?page=td_city&city-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=td_city&city-deleted=false' );
        }
        wp_redirect( $redirected_to );
        exit;
    }

    public function handle_form() {
        if ( ! isset( $_POST['submit_tdcity'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'taslim_happy_nonce' ) ) {
            die( __( 'Are you cheating?', 'teamdigital' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'teamdigital' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=td_city' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $table = isset( $_POST['table'] ) ? sanitize_text_field( $_POST['table'] ) : 'td_city';
        $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $postcode = isset( $_POST['postcode'] ) ? sanitize_text_field( $_POST['postcode'] ) : '';
        $burial_place = isset( $_POST['burial_place'] ) ? sanitize_text_field( $_POST['burial_place'] ) : '';
        $transport_price = isset( $_POST['transport_price'] ) ? sanitize_text_field( $_POST['transport_price'] ) : '';
        $zerotosixmaanden = isset( $_POST['zerotosixmaanden'] ) ? sanitize_text_field( $_POST['zerotosixmaanden'] ) : '';
        $sixtotwelvejaar = isset( $_POST['sixtotwelvejaar'] ) ? sanitize_text_field( $_POST['sixtotwelvejaar'] ) : '';
        $ouderdantwelve = isset( $_POST['ouderdantwelve'] ) ? sanitize_text_field( $_POST['ouderdantwelve'] ) : '';
        $meta_info = isset( $_POST['meta_info'] ) ? wp_kses_post( $_POST['meta_info'] ) : '';

        // some basic validation
        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'name' => $name,
            'postcode' => $postcode,
            'burial_place' => $burial_place,
            'transport_price' => $transport_price,
            'zerotosixmaanden' => $zerotosixmaanden,
            'sixtotwelvejaar' => $sixtotwelvejaar,
            'ouderdantwelve' => $ouderdantwelve,
            'meta_info' => $meta_info,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = taslim_city_insert_City( $fields, $table );

        } else {

            $fields['id'] = $field_id;

            $insert_id = taslim_city_insert_City( $fields, $table );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = admin_url( 'admin.php?page=td_city&city-insert=false' );
        } else {
            $redirect_to = admin_url( 'admin.php?page=td_city&city-insert=true' );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
    public function handle_kist_form() {
        if ( ! isset( $_POST['submit_tdkist'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'taslim_happy_nonce' ) ) {
            die( __( 'Are you cheating?', 'teamdigital' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'teamdigital' ) );
        }


        $kistitem = [];
        if(isset($_REQUEST['kistname']) && $_REQUEST['price'] && count($_REQUEST['kistname']) !== 0 && count($_REQUEST['price']) !== 0 ) {

            $totalitem = count($_REQUEST['kistname']);
            $kistname = $_REQUEST['kistname'];
            $kistprice = $_REQUEST['price'];

            for ($i=0; $i < $totalitem; $i++) { 
                $kistitem[$i] = array(
                    'name' => $kistname[$i],
                    'price' => $kistprice[$i]
                );
            }
        }

        $updatekist = update_option( 'kist_itams', $kistitem);

        if ( is_wp_error( $updatekist ) ) {
            $redirect_to = admin_url( 'admin.php?page=td_kist&kist-insert=false' );
        } else {
            $redirect_to = admin_url( 'admin.php?page=td_kist&kist-insert=true' );
        }

        wp_safe_redirect( $redirect_to );
        exit;

    }
}

new Form_Handler();

function get_all_city( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 2000000,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
        'table'      => 'td_city',
    );

    $args      = wp_parse_args( $args, $defaults );
    $table = $wpdb->prefix.$args['table'];
    $items = $wpdb->get_results( 'SELECT * FROM ' . $table .' ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );
    return $items;
}

function taslim_city_count($atable = 'td_city') {
    global $wpdb;
    $table = $wpdb->prefix.$atable;
    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $table );
}

function taslim_city_get( $id = 0, $atable = 'td_city' ) {
    global $wpdb;
    $table = $wpdb->prefix.$atable;
    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $table .' WHERE id = %d', $id ) );
}

function taslim_city_delete( $id, $atable = 'td_city'  ) {
    global $wpdb;
    $table = $wpdb->prefix.$atable;
    return $wpdb->delete(
        $table,
        [ 'id' => $id ],
        [ '%d' ]
    );
}
