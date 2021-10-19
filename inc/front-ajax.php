<?php
add_action( 'wp_ajax_td_from_price', 'callback_td_from_price' );
add_action( 'wp_ajax_nopriv_td_from_price', 'callback_td_from_price' );
function callback_td_from_price() {
    if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'taslim-admin-nonce' ) ) {
        wp_send_json_error( [
            'message' => 'Nonce verification failed!',
        ] );
    }
        $alldata = $_REQUEST;
        $formfor = isset( $_REQUEST['formfor'] ) ? sanitize_text_field( $_REQUEST['formfor'] ) : 'begraving';
        $citypriceOne = isset( $_REQUEST[CITYPRICEONE] ) ? (float) sanitize_text_field( $_REQUEST[CITYPRICEONE] ) : (float) 0;
        $citypriceTwo = isset( $_REQUEST[CITYPRICETWO] ) ? (float) sanitize_text_field( $_REQUEST[CITYPRICETWO] ) : (float) 0;
        $citycremtie = isset( $_REQUEST[CITYCREMATIE] ) ? (float) sanitize_text_field( $_REQUEST[CITYCREMATIE] ) : (float) 0;
        $kistprice = isset( $_REQUEST[KIST] ) ? (float) sanitize_text_field( $_REQUEST[KIST] ) : (float) 0;
        $tddate = isset( $_REQUEST['tddate'] ) ? sanitize_text_field( $_REQUEST['tddate'] ) : '';
 
        //$citypriceTwo == 0 || $citycremtie == 0
        if ( $citypriceOne == 0 || empty($tddate)){
            wp_send_json_success( [
                'message' => 0,
              ] );
        }

        $price_field = [];
        foreach ($alldata as $key => $value) {
            $price_fields = get_price_value($value, $key, $formfor);
            if (!empty($price_fields)) {
                $price_field[] = $price_fields;
            }
        }

        $taslim_amount = 0;
        $taslim_amount += (float) $citypriceOne;
        $taslim_amount += (float) $citypriceTwo;
        $taslim_amount += (float) $kistprice;
        if (count($price_field) != 0) {
            foreach ($price_field as $value) {
                $taslim_amount += (float) ($value['price']) ? $value['price'] : 0;
            }
        }

        wp_send_json_success( [
          'message' => $taslim_amount,
        ] );

        wp_send_json_error( [
            'message' => 'Sorry something wrong!',
        ] );
}

add_action( 'wp_ajax_td_from_previw', 'callback_td_from_previw' );
add_action( 'wp_ajax_nopriv_td_from_previw', 'callback_td_from_previw' );
function callback_td_from_previw() {
    if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'taslim-admin-nonce' ) ) {
        wp_send_json_error( [
            'message' => 'Nonce verification failed!',
        ] );
    }

        $formfor = isset( $_REQUEST['formfor'] ) ? sanitize_text_field( $_REQUEST['formfor'] ) : 'begraving';
        $citypriceOne = isset( $_REQUEST[CITYPRICEONE] ) ? sanitize_text_field( $_REQUEST[CITYPRICEONE] ) : 0;
        $citypriceTwo = isset( $_REQUEST[CITYPRICETWO] ) ? sanitize_text_field( $_REQUEST[CITYPRICETWO] ) : 0; 
        $kistprice = isset( $_REQUEST[KIST] ) ? (float) sanitize_text_field( $_REQUEST[KIST] ) : (float) 0;   
        $alldata = $_REQUEST;
        $price_field = [];
        $newprice_field = [];

        foreach ($alldata as $key => $value) {
            $price_fields = get_price_value($value, $key, $formfor);
            if (!empty($price_fields)) {
                $price_field[] = $price_fields;
                $childlist = [];
                //$childlist[$price_fields['name']] = $price_fields;
                $newprice_field[$price_fields['name']][] = $price_fields;
            }
        }


        $taslim_amount = 0;
        $taslim_amount += (float) $citypriceOne;
        $taslim_amount += (float) $citypriceTwo;        
        $taslim_amount += (float) $kistprice;        
        if (count($price_field) != 0) {
            foreach ($price_field as $value) {
                $taslim_amount += ($value['price'])? $value['price'] : 0;
            }
        }

        echo td_generateinvoice( $newprice_field, $alldata );
        die();

        // wp_send_json_success( [
        //     'message' => td_generateinvoice( $price_field, $alldata ),
        // ] );

        wp_send_json_error( [
            'message' => 'Sorry something wrong!',
        ] );
}


add_action( 'wp_ajax_td_from_checkout', 'callback_td_from_checkout' );
add_action( 'wp_ajax_nopriv_td_from_checkout', 'callback_td_from_checkout' );
function callback_td_from_checkout() {
        if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'taslim-admin-nonce' ) ) {
            wp_send_json_error( [
                'message' => 'Nonce verification failed!',
            ] );
        }

        $formfor = isset( $_REQUEST['formfor'] ) ? sanitize_text_field( $_REQUEST['formfor'] ) : 'begraving';
        $citypriceOne = isset( $_REQUEST[CITYPRICEONE] ) ? sanitize_text_field( $_REQUEST[CITYPRICEONE] ) : 0;
        $citypriceTwo = isset( $_REQUEST[CITYPRICETWO] ) ? sanitize_text_field( $_REQUEST[CITYPRICETWO] ) : 0;
        $kistprice = isset( $_REQUEST[KIST] ) ? sanitize_text_field( $_REQUEST[KIST] ) : 0;

        $alldata = $_REQUEST;
        $price_field = [];
        foreach ($alldata as $key => $value) {
            $price_fields = get_price_value($value, $key, $formfor);
            if (!empty($price_fields)) {
                $price_field[] = $price_fields;
            }
        }

        $taslim_amount = 0;
        $taslim_amount += (float) $citypriceOne;
        $taslim_amount += (float) $citypriceTwo;
        $taslim_amount += (float) $kistprice;   
        if (count($price_field) != 0) {
            foreach ($price_field as $value) {
                $taslim_amount += ($value['price'])? $value['price'] : 0;
            }
        }

        do_action('woocommerce_init');
        WC()->cart->empty_cart();
        WC()->cart->add_to_cart(PRODUCTID, 1,'',array(), array('td_price' => $taslim_amount, 'orderdetial' => $alldata, 'orderprices' => $price_field));

        wp_send_json_success( [
            'message' => wc_get_checkout_url(),
        ] );

        wp_send_json_error( [
            'message' => 'Sorry something wrong!',
        ] );
}

// Display custom cart item meta data (in cart and checkout)
// add_filter( 'woocommerce_get_item_data', 'display_cart_item_custom_meta_data', 10, 2 );
// function display_cart_item_custom_meta_data( $item_data, $cart_item ) {

//     if ( isset($cart_item['orderdetial']) ) {
//         $item_data[] = array(
//             'key'       => 'orderdetial',
//             'value'     => serialize($cart_item['orderdetial']),
//         );
//     }
//     if ( isset($cart_item['orderprices']) ) {
//         $item_data[] = array(
//             'key'       => 'orderprices',
//             'value'     => serialize($cart_item['orderprices']),
//         );
//     }

//     return $item_data;
// }



add_action( 'woocommerce_checkout_update_order_meta', function( $order_id, $data){

    $cartvalue = WC()->cart->get_cart();
    foreach ( $cartvalue as $cart_item_key => $values ) {

        if(isset($values['orderdetial'])){
            update_post_meta( $order_id, 'orderdetial', $values['orderdetial']);
        }
        if(isset($values['orderprices'])){
            update_post_meta( $order_id, 'orderprices', $values['orderprices']);
        }

    }
}, 10, 2 );

add_action( 'add_meta_boxes', 'taslim_wc_order_details' );

 function taslim_wc_order_details() {
    add_meta_box(
        'order_details',
        'Order Details',
        'render_taslim_wc_order_details',
        'shop_order',
        'normal',
        'high'
    );
}
function render_taslim_wc_order_details( $post ) { 
    $order_id = $post->ID;
    $ordermetas = get_post_meta( $post->ID );
    $orderdetial = (isset($ordermetas['orderdetial'])) ? unserialize($ordermetas['orderdetial'][0]) : [];
    $orderprices = (isset($ordermetas['orderprices'])) ? unserialize($ordermetas['orderprices'][0]) : [];


    $newprice_field = [];

    foreach ($orderprices as $key => $price_fields) {
        $newprice_field[$price_fields['name']][] = $price_fields;
    }

    // echo "<pre>";
    // print_r( $orderprices );
    // echo "</pre>";

    //  echo tdgetorder_details($orderdetial, $orderprices);



     echo td_admin_generateinvoice($newprice_field, $orderdetial);

    // echo "<pre>";
    // print_r( $orderdetial );
    // //print_r( $orderprices );
    // echo "</pre>";

?>
<style>
.tdinvoice_preview table {
    width: 100%;
}
.taslim-resource {}
.taslim-resource h2 {
    font-size: 24px !important;
    padding-left: 0px !important;
    font-weight: 700 !important;
    margin-top: 30px !important;
}
.taslim-resource p span{
    font-weight:700;
}

div#tdinvoice {
  /* max-width: 900px; */
  margin-top: 15px;
}

.tdw-50 {
  width: 50%;
}
.tdinvoice table th {
  font-size: 14px;
}
.tdinvoice_preview {
  background: #fff;
  padding: 15px;
  font-size: 16px;
  border: 10px solid #222;
}
ul.tdinvoice-topinfo {
  list-style: none;
  padding-left: 15px;
}

ul.tdinvoice-topinfo li span {
  width: 200px;
  display: inline-block;
}

h4.tdinvoice_heading {
  border-bottom: 1px solid #aaa;
  font-size: 18px;
  padding-bottom: 8px;
  margin-bottom: 8px;
}
.tdmt-15 {
  margin-top:15px;
}
.tdinvoice table, .tdinvoice table td, .tdinvoice table th {
  border: 0px;
  padding: 0px;
}

</style>
<div class="taslim-resource">
<h2>Custom resource</h2>
<?php
foreach ($orderdetial as $key => $value) {
    if(is_array($value)){
        $img_pomd = get_tdresources( $key, 'a' );
        foreach($value as $cvalue) {
            $tdchildvalue = $cvalue;
        }
        if($img_pomd['type'] == 'image'){
            $tdimg = wp_get_attachment_image_src( $tdchildvalue, 'full' );
            $imgurl = (isset($tdimg[0]))? $tdimg[0] : '';
            echo '<p><span>'.$img_pomd['label'].'</span> : <a href="'.$imgurl.'">'.$imgurl.'</a></p>';
        }
        if($img_pomd['type'] == 'poem'){
            echo '<p><span>'.$img_pomd['label'].'</span> : <textarea style="width: 100%;" cols="30" rows="3">'.$tdchildvalue.'</textarea></p>';
        }
    }
}

?>
</div>
<?php };


