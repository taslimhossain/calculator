<?php
add_action( 'wp_ajax_taslim_create_fields', 'callback_taslim_create_fields' );
add_action( 'wp_ajax_nopriv_taslim_create_fields', 'callback_taslim_create_fields' );

add_action( 'wp_ajax_taslim_form_fields_save', 'callback_taslim_form_fields_save' );
add_action( 'wp_ajax_nopriv_taslim_form_fields_save', 'callback_taslim_form_fields_save' );


function callback_taslim_create_fields() {

    if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'taslim-admin-nonce' ) ) {
        wp_send_json_error( [
            'message' => 'Nonce verification failed!',
        ] );
    }

 	$field_type = isset( $_REQUEST['field_type'] ) ? sanitize_text_field( $_REQUEST['field_type'] ) : '';
    $field_row = isset( $_REQUEST['field_row'] ) ? sanitize_text_field( $_REQUEST['field_row'] ) : '0';
 	$field_id = $field_row;

 	if (!empty($field_type)) {
	    wp_send_json_success( [
	        'message' => getFieldHTML($field_type, $field_id)
	    ] );
 	}

    wp_send_json_error( [
        'message' => 'Sorry something wrong!',
    ] );

}


function callback_taslim_form_fields_save() {

    if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'form_fields_save' ) ) {
        wp_send_json_error( [
            'message' => 'Nonce verification failed!',
        ] );
    }

    $fields = isset( $_REQUEST['field'] ) ? $_REQUEST['field'] : '0';
    $formname = isset( $_REQUEST['formname'] ) ? $_REQUEST['formname'] : '';
    if(! $formname ){
        return;
    }

    $tdfields       = [];
    $tdoptionsarray = [];


    if (is_array($fields) && count($fields) != 0):

        $newFields = [];
        $field_number = 0;
        $i = 0;
        foreach ($fields as $value) {
            $field_number++;
            $i++;
            $key = array_keys($value)[0];

            if (!empty($key)):
                $tdoptions            = $value[$key]['optionvalue'];
                $optionlabel          = (isset($value[$key]['optionlabel'])) ? $value[$key]['optionlabel'] : array();
                $optionvalue          = $value[$key]['optionvalue'];
                $optionprice          = (isset($value[$key]['optionprice'])) ? $value[$key]['optionprice'] : array();
                $optiontax            = (isset($value[$key]['optiontax'])) ? $value[$key]['optiontax'] : '';
                $optiondescription    = (isset($value[$key]['optiondescription'])) ? $value[$key]['optiondescription'] : '';
                $optiondescriptiontwo = (isset($value[$key]['optiondescriptiontwo'])) ? $value[$key]['optiondescriptiontwo'] : array();
                $optionshow           = (isset( $value[$key]['optionshow'])) ?  $value[$key]['optionshow'] : array(); 
                if (is_array($tdoptions) && count($tdoptions) != 0){
                    for ($x=0; $x <= count($tdoptions); $x++) {
                        if(isset($optionlabel[$x]) && !empty($optionlabel[$x])){
                            $tdoptionsarray[] = array(
                                'key'                  => (isset($optionlabel[$x])) ? $optionlabel[$x] : '',
                                'value'                => (isset($optionvalue[$x])) ? $optionvalue[$x] : '',
                                'price'                => (isset($optionprice[$x])) ? $optionprice[$x] : '',
                                'tax'                  => (isset($optiontax[$x])) ? $optiontax[$x] : '',
                                'optiondescription'    => (isset($optiondescription[$x])) ? $optiondescription[$x] : '',
                                'optiondescriptiontwo' => (isset($optiondescriptiontwo[$x])) ? $optiondescriptiontwo[$x] : '',
                                'optionshow'           => (isset($optionshow[$x])) ? $optionshow[$x] : ''
                            );
                        }
                    }
                }

                $tdfields[] = array(
                    'type'           => $key,
                    'label'          => $value[$key]['label'][0],
                    'name'           => $value[$key]['name'][0],
                    'title'          => $value[$key]['title'][0],
                    'description'    => $value[$key]['description'][0],
                    'options'        => $tdoptionsarray,
                    'required'       => isset( $value[$key]['required'][0] ) && !empty( $value[$key]['required'][0] ) ? 'checked'  : '',
                    'show'           => isset( $value[$key]['show'][0] ) && !empty( $value[$key]['show'][0] ) ? 'checked'  : '',
                    'custom_image'           => isset( $value[$key]['custom_image'][0] ) && !empty( $value[$key]['custom_image'][0] ) ? 'checked'  : '',
                    'condition'      => $value[$key]['condition'][0],
                    'conditionvalue' => $value[$key]['conditionvalue'][0],
                );
                $tdoptionsarray = [];
            endif;

        }

    endif;    

    // echo "<pre>";
    // print_r($tdfields);
    // echo "</pre>";
    // die();

    if($formname == 'td_begraving'){
        update_option( 'tdfuneral_forms', $tdfields, true);
    }

    if($formname == 'td_cremation'){
        update_option( 'td_cremation_forms', $tdfields, true);
    }

    // echo count($fields);

    wp_send_json_error( [
        'message' => 'success',
    ] );

}