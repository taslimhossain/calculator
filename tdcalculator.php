<?php
/**
 * Plugin Name: Td Funeral Calculator
 * Plugin URI: https://teamdigital.be
 * Description: Td funeral calculator wordpress plugin by teamdigital - [tdfuneralform].
 * Version: 1
 * Author: teamdigitalf
 * Author URI: https://teamdigital.be
 * Text Domain: teamdigital
 * Domain Path: /teamdigital/
 *
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

//define( 'PRODUCTID', 31 ); local server
define( 'PRODUCTID', 69 );
define( 'CITYPRICEONE', 'transport' );
define( 'CITYPRICETWO', 'begraving' );
define( 'CITYCREMATIE', 'crematie' );
define( 'KIST', 'kist' );

$tBegraving = get_price_value('Begraving', 'Begraving', 'begraving');
$tTransport = get_price_value('Transport', 'Transport', 'begraving');
$tKist = get_price_value('Kist', 'Kist', 'begraving');
$crematie = get_price_value('Crematie', 'Crematie', 'cremation');

$begravingTax = (isset($tBegraving['tax'])) ? $tBegraving['tax'] : 0;
$transportTax = (isset($tTransport['tax'])) ? $tTransport['tax'] : 0;
$kistTax = (isset($tKist['tax'])) ? $tKist['tax'] : 0;
$crematieTax = (isset($crematie['tax'])) ? $crematie['tax'] : 0;

define( 'BEGRAVING_TAX', $begravingTax );
define( 'TRANSPORT_TAX', $transportTax );
define( 'KISTTAX', $kistTax );
define( 'CREMATIE_TAX', $crematieTax );

define( 'TDPLUGINDIR', plugin_dir_url( __FILE__ ) );

require plugin_dir_path( __FILE__ ) . 'inc/taslim_upload.php';
require plugin_dir_path( __FILE__ ) . 'inc/taslim-array.php';
require plugin_dir_path( __FILE__ ) . 'inc/td_city.php';
require plugin_dir_path( __FILE__ ) . 'inc/taslim-admin-page.php';
require plugin_dir_path( __FILE__ ) . 'inc/taslim-fields-types.php';
require plugin_dir_path( __FILE__ ) . 'td-pdf.php';
require plugin_dir_path( __FILE__ ) . 'inc/front-ajax.php';
require plugin_dir_path( __FILE__ ) . 'inc/taslim-ajax.php';
require plugin_dir_path( __FILE__ ) . 'inc/taslim_front.php';
require plugin_dir_path( __FILE__ ) . 'inc/taslim-form.php';
require plugin_dir_path( __FILE__ ) . 'inc/td_details.php';

add_action( 'wp_enqueue_scripts', 'taslim_front_enqueue_scripts' );
function taslim_front_enqueue_scripts() {
    wp_enqueue_script( 'td-datepicker', plugin_dir_url( __FILE__ ) . 'js/datepicker.min.js', array( 'jquery' ), time(), true );
    wp_enqueue_script( 'td-select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), time(), true );
    wp_enqueue_script( 'td-custom', plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), time(), true );

    wp_localize_script( 'td-custom', 'taslimAjax', [
        'ajaxurl'      => admin_url( 'admin-ajax.php' ),
        'nonce'        => wp_create_nonce( 'taslim-admin-nonce' ),
        'confirm'      => __( 'Bent u zeker?', 'teamdigital' ),
        'error'        => __( 'Er ging iets fout!', 'teamdigital' ),
        'citypriceone' => CITYPRICEONE,
        'citypricetwo' => CITYPRICETWO,
        'citycrematie' => CITYCREMATIE,
    ] );

    wp_enqueue_style( 'td-datepicker', plugin_dir_url( __FILE__ ) . 'css/datepicker.min.css', array(), time(), 'all' );
    wp_enqueue_style( 'td-select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), time(), 'all' );
    wp_enqueue_style( 'td-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), time(), 'all' );
}

add_action( 'admin_enqueue_scripts', 'taslim_admin_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'taslim_admin_enqueue_style' );

function taslim_admin_enqueue_scripts( $hook ) {

    $taslim_page = ['toplevel_page_tdfuneral', 'toplevel_page_td_city'];

    if ( in_array( $hook, $taslim_page ) ) {
        wp_enqueue_script( 'jquery-ui-draggable' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jquery-ui-droppable' );
    }

    wp_enqueue_script( 'taslim-admin', plugin_dir_url( __FILE__ ) . 'js/taslim-admin.js', array( 'jquery' ), time(), true );
    //wp_enqueue_script( 'happytaslim-admin', 'http://127.0.0.1/wp/wp-admin/js/inline-edit-post.js?ver=5.5.1', array( 'jquery' ), time(), true );

    wp_localize_script( 'taslim-admin', 'taslimAjax', [
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'taslim-admin-nonce' ),
        'confirm' => __( 'are you sure?', 'teamdigital' ),
        'error'   => __( 'Something went wrong', 'teamdigital' ),
    ] );

}

function taslim_admin_enqueue_style( $hook ) {

    $taslim_page = ['toplevel_page_tdfuneral', 'toplevel_page_td_city'];

    if ( in_array( $hook, $taslim_page ) ) {
        wp_register_style( 'jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' );
    }

    wp_enqueue_style( 'taslim-admin', plugin_dir_url( __FILE__ ) . 'css/taslim-admin.css', array(), time(), 'all' );

}

/** Create database */
register_activation_hook( __FILE__, 'taslim_create_tables' );
function taslim_create_tables() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}td_city` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL DEFAULT '',
          `postcode` varchar(255) DEFAULT NULL,
          `burial_place` varchar(255) DEFAULT NULL,
          `transport_price` varchar(255) DEFAULT NULL,
          `meta_info` TEXT DEFAULT NULL,
          `created_at` datetime NOT NULL,
          PRIMARY KEY (`id`)
        ) $charset_collate";

    if ( ! function_exists( 'dbDelta' ) ) {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    }

    dbDelta( $schema );
}

function get_fiellvalue( $key ) {
    $getFields     = stripslashes_deep( get_option( 'tdfuneral_forms', true ) );
    $taslim_values = [];
    for ( $i = 0; $i <= count( $getFields ); $i++ ) {
        if ( isset( $getFields[$i]['options'] ) ):
            $opfield = $getFields[$i]['options'];
            for ( $x = 0; $x <= count( $opfield ); $x++ ) {
                if ( isset( $opfield[$x] ) ) {
                    $taslim_key                 = ( isset( $opfield[$x]['value'] ) ) ? $opfield[$x]['value'] : 'empty';
                    $taslim_values[$taslim_key] = array(
                        'label' => ( isset( $getFields[$i]['label'] ) ) ? $getFields[$i]['label'] : '',
                        'key'   => ( isset( $opfield[$x]['key'] ) ) ? $opfield[$x]['key'] : '',
                        'value' => ( isset( $opfield[$x]['value'] ) ) ? $opfield[$x]['value'] : '',
                        'price' => ( isset( $opfield[$x]['price'] ) ) ? $opfield[$x]['price'] : '',
                    );
                }
            }
        endif;
    }
    return ( isset( $taslim_values[$key] ) ) ? $taslim_values[$key] : 'nai';
}

//$halele = get_fiellvalue('taslim');

function get_price_value( $pkey, $pvalue, $formfor = 'begraving' ) {

    if($formfor == 'cremation') {
        $getFields = stripslashes_deep( get_option( 'td_cremation_forms', true ) );
    } else {
        $getFields = stripslashes_deep( get_option( 'tdfuneral_forms', true ) );
    }

    $taslim_values = [];
    for ( $i = 0; $i <= count( $getFields ); $i++ ) {
        if ( isset( $getFields[$i]['options'] ) ):
            $opfield = $getFields[$i]['options'];
            for ( $x = 0; $x <= count( $opfield ); $x++ ) {
                if ( isset( $opfield[$x] ) ) {
                    $taslim_values[] = array(
                        'type'  => ( isset( $getFields[$i]['type'] ) ) ? $getFields[$i]['type'] : '',
                        'name'  => ( isset( $getFields[$i]['name'] ) ) ? $getFields[$i]['name'] : '',
                        'label' => ( isset( $getFields[$i]['label'] ) ) ? $getFields[$i]['label'] : '',
                        'key'   => ( isset( $opfield[$x]['key'] ) ) ? $opfield[$x]['key'] : '',
                        'value' => ( isset( $opfield[$x]['value'] ) ) ? $opfield[$x]['value'] : '',
                        'price' => ( isset( $opfield[$x]['price'] ) ) ? $opfield[$x]['price'] : 0,
                        'tax'   => ( isset( $opfield[$x]['price'] ) ) ? $opfield[$x]['tax'] : 0,
                    );
                }
            }
        endif;
    }


    $returnvalue = [];
    if ( count( $taslim_values ) != 0 ) {
        foreach ( $taslim_values as $value ) {

            if (  (  ( isset( $value['name'] ) && $value['name'] === $pkey ) ) || (  ( isset( $value['key'] ) && $value['key'] === $pkey ) ) ) {
                $returnvalue = $value;
            }
            // if ( ( (isset($value['name']) && $value['name'] === $pkey) || (isset($value['key']) && $value['key'] === $pkey) ) && ( isset($value['value']) && $value['value'] === $pvalue ) ) {

            // }

        }
    }
    return $returnvalue;
}

// Set insurance price from custom cart item data
add_action( 'woocommerce_before_calculate_totals', 'set_tdcalculate_price' );
function set_tdcalculate_price( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    foreach ( $cart->get_cart() as $cart_item ) {
        if ( isset( $cart_item['td_price'] ) && $cart_item['td_price'] > 0 && $cart_item['product_id'] == PRODUCTID ) {
            $cart_item['data']->set_price( $cart_item['td_price'] );
        }
    }
}

//conditionField

function taslim_get_condition($getFields) {
    //$getFields     = stripslashes_deep( get_option( 'tdfuneral_forms', true ) );
    $datacondition = [];
    if ( is_array( $getFields ) && count( $getFields ) != 0 ):
        foreach ( $getFields as $key => $field ) {
            $vcondition = ( isset( $field['condition'] ) && ! empty( $field['condition'] ) ) ? $field['condition'] : '';
            if ( empty( $vcondition ) ) {
                continue;
            }
            $datacondition[] = [
                'name'           => ( isset( $field['name'] ) && ! empty( $field['name'] ) ) ? $field['name'] : '',
                'condition'      => ( isset( $field['condition'] ) && ! empty( $field['condition'] ) ) ? $field['condition'] : '',
                'conditionvalue' => ( isset( $field['conditionvalue'] ) && ! empty( $field['conditionvalue'] ) ) ? $field['conditionvalue'] : '',
            ];
        }
    endif;
    return $datacondition;
}

//add_action( 'wp_head', 'taslim_wp_head_css', 10, 1 );
function taslim_wp_head_css() {
  $tgetcon = taslim_get_condition();
  ob_start();?>
  <script>
    ( function( $ ) {
      jQuery(document).ready(function($) {
      console.log('hello');
    <?php
    if ( is_array( $tgetcon ) && count( $tgetcon ) != 0 ):
        foreach ( $tgetcon as $value ) {?>
						$(".con_<?php echo $value['name']; ?>").hide();

						var value = $("[name='radio_service']");

						  $("input[name='<?php echo $value['condition']; ?>']").change(function() {
						  console.log($(this).val());
						    if($(this).val() === '<?php echo $value['conditionvalue']; ?>'){
						      $(".con_<?php echo $value['name']; ?>").show();
						    } else if( '<?php echo $value['conditionvalue']; ?>' === 'click') {
						      $(".con_<?php echo $value['name']; ?>").show();
						    }else {
						      $(".con_<?php echo $value['name']; ?>").hide();
						      $(".con_<?php echo $value['name']; ?>").find('input[type=checkbox][notchange="disabled"]').prop('checked', false);

						      $(".con_<?php echo $value['name']; ?>").find('input[type=radio]').prop('checked', false);
						      $(".con_<?php echo $value['name']; ?>").find('select').val('');;

						    }

						    if($(this).val() === 'click'){
						      $(".con_<?php echo $value['name']; ?>").hide();
						      $(".con_<?php echo $value['name']; ?>").find('input[type=checkbox][notchange="disabled"]').prop('checked', false);
						      $(".con_<?php echo $value['name']; ?>").find('input[type=radio]').prop('checked', false);
						      $(".con_<?php echo $value['name']; ?>").find('select').val('');;
						    }


						  });
						    console.log('hellos');
						<?php }
    endif;
    ?>

    });
    }( jQuery ) );
  </script>
  <?php echo ob_get_clean();
}
function get_field_type_title( $title = '' ) {

    $tim_fieldlist = array(
        'title'         => array(
            'title' => 'Title',
            'slug'  => 'title',
        ),
        'description'   => array(
            'title' => 'Description',
            'slug'  => 'description',
        ),
        'basic_service' => array(
            'title' => 'Select Multiple Checkbox',
            'slug'  => 'basic_service',
        ),
        'radio_service' => array(
            'title' => 'Select Single Checkbox',
            'slug'  => 'radio_service',
        ),
        'select_price'  => array(
            'title' => 'Select Dropdown',
            'slug'  => 'select_price',
        ),
        'image'         => array(
            'title' => 'Select Image',
            'slug'  => 'image',
        ),
        'image_price'   => array(
            'title' => 'Select Image with price',
            'slug'  => 'image_price',
        ),
        'poem'          => array(
            'title' => 'Select Text',
            'slug'  => 'poem',
        ),
    );

    foreach ( $tim_fieldlist as $value ) {
        if ( $title == $value['slug'] ) {
            $ftitle = $value['title'];
        }
    }
    return $ftitle;
}

function taslim_load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'taslim_load_media_files' );

add_action( 'init', function(){
    if( !isset($_GET['downloadpdf']) ) {
        return;
    }

    $timPdf = get_transient( $_GET['downloadpdf'] );
    if(empty($timPdf)){
        return;
    }
    $data = base64_decode($timPdf);
    header('Content-Type: application/pdf');
    echo $data;
    die();
});

function kist_list(){
    $kist =  array(
		'0_tot_6_maanden'       => '0 tot 6 maanden',
		'6_maanden_tot_12_jaar' => '6 maanden tot 12 jaar',
        'Ouder_dan_12_jaar'     => 'Ouder dan 12 jaar',
    );
    return $kist;
}

add_action('template_redirect', function(){
	if( is_product_category()  || is_shop() ){
		wp_safe_redirect( home_url() );
        exit;
	}
});
