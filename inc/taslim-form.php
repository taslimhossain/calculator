<?php
add_shortcode( 'tdfuneralform', 'taslim_tdfuneral_form' );
function taslim_tdfuneral_form( $atts ) {

		// Attributes
		$atts = shortcode_atts(
			array(
				'for' => '',
			),
			$atts,
			'tdfuneralform'
		);

	$formData = (isset( $_POST )) ? $_POST : '';
	if (!empty($formData) && isset( $_POST ) ) {
		echo "<pre>";
		print_r($formData);
		echo "</pre>";
	}

	if($atts['for'] == 'cremation'){
		$getFields = stripslashes_deep(get_option( 'td_cremation_forms', true ));
		$formfor = '<input type="hidden" name="formfor" value="cremation">';
		$tgetcon = taslim_get_condition($getFields);

	} else {
		$getFields = stripslashes_deep(get_option( 'tdfuneral_forms', true ));
		$formfor = '<input type="hidden" name="formfor" value="begraving">';
		$tgetcon = taslim_get_condition($getFields);
	}

	
	ob_start();
	?>
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


	<?php
	echo '<form action="" method="post" id="tdfromfront" class="tdformarea">';
	echo '<input type="hidden" name="get_ajax_price" value="0">';
	echo $formfor;
	?>

	<div class="lds-spinner" id="tdformloader">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>

<div class="td-formfixedfield">
	<div class="select-date td-select-date">
		<!-- <input name="tddate" value="" class="form-control" data-toggle="datepicker" autocomplete="off" placeholder="Geboortedatum"> -->
		<select name="tddate" id="select_tddate" class="form-control tddateselect">
			<?php
				$get_kist = get_option( 'kist_itams' );
				if( count($get_kist) != 0 ){
					foreach ( $get_kist as $key => $value) {
						$kisstprice = ($atts['for'] != 'cremation') ? 'kistprice="'.$value['price'].'"' : '';
						$cremationage = '';
						if($value['name'] == 'Ouder dan 12 jaar'){
							$cremationage = 'ouderdantwelve';
						}
						if($value['name'] == '6 maanden tot 12 jaar'){
							$cremationage = 'sixtotwelvejaar';
						}
						if($value['name'] == '0 tot 6 maanden'){
							$cremationage = 'zerotosixmaanden';
						}
						echo '<option value="'.$value['name'].'"  '.$kisstprice.' age="'.$cremationage.'" >'.$value['name'].'</option>';
					}
				}
			?>
		</select>
	</div>
	<div class="select-city td-select-city">
		<select class="td-select-cityselectone" id="cityselectone" name="cityselectone">
			<option value="0" cityprice="0" >Gemeente van overlijden</option>
			<?php

			if($atts['for'] == 'cremation'){
				$allcity = get_all_city( array('table' => 'td_ccity'));
			} else {
				$allcity = get_all_city();
			}

			if(is_array($allcity) && count($allcity) != 0) :
			    foreach ($allcity as $city) :
				if($city->transport_price):
			?>
				<option value="<?php echo $city->name; ?>" cityprice="<?php echo $city->transport_price; ?>" ><?php echo $city->name; ?> <?php echo $city->postcode; ?></option>
			<?php
				endif;
			endforeach;
			endif;
			?>
		</select>
	</div>
	<div class="select-city td-select-city">
		<select class="td-select-cityselettwo" id="cityselettwo" name="cityselettwo">
			<option value="0" cityprice="0" >Woonplaats</option>
			<?php

			if($atts['for'] == 'cremation'){
				$allcity = get_all_city( array('table' => 'td_ccity'));
			} else {
				$allcity = get_all_city();
			}



			if(is_array($allcity) && count($allcity) != 0) :
			    foreach ($allcity as $city) :
			    	if($city->transport_price):
			?>
				<option value="<?php echo $city->name; ?>" cityprice="<?php echo $city->burial_place; ?>" zerotosixmaanden="<?php echo $city->zerotosixmaanden; ?>" sixtotwelvejaar="<?php echo $city->sixtotwelvejaar; ?>" ouderdantwelve="<?php echo $city->ouderdantwelve; ?>" > <?php echo $city->name; ?> <?php echo $city->postcode; ?></option>
			<?php
			endif;
			endforeach;
			endif;
			?>
		</select>
	</div>

</div>

<?php	
	if (is_array($getFields) && count($getFields) != 0):

			$remove_style = ['title','description'];
			foreach ($getFields as $key => $field) {
				$data = [
					'key'          => (isset($key) && !empty($key)) ? $key : '',
					'type'         => (isset($field['type']) && !empty($field['type'])) ? $field['type'] : '',
					'value'        => (isset($field['value']) && !empty($field['value'])) ? $field['value'] : '',
					'label'        => (isset($field['label']) && !empty($field['label'])) ? $field['label'] : '',
					'name'         => (isset($field['name']) && !empty($field['name'])) ? $field['name'] : '',
					'required'     => (isset($field['required']) && !empty($field['required'])) ? 'required' : '',
					'title'        => (isset($field['title']) && !empty($field['title'])) ? $field['title'] : '',
					'description'  => (isset($field['description']) && !empty($field['description'])) ? $field['description'] : '',
					'options'      => (isset($field['options']) && !empty($field['options'])) ? $field['options'] : '',
					'custom_image' => (isset($field['custom_image']) && !empty($field['custom_image'])) ? $field['custom_image'] : 'nochecked'
				];

				$is_show = (isset($field['show']) && !empty($field['show'])) ? $field['show'] : '';

				$functiontype = (isset($field['type']) && !empty($field['type'])) ? $field['type'] : '_';
				$function = 'taslim_front_'.$functiontype;
				if(function_exists($function) && $is_show != 'checked') {

					if (in_array($data['type'], $remove_style)) :
						echo $function($data);
					else : 	
				echo '<div class="con_'.$data['name'].'">';
						echo '<div class="td-accordion tda-inactive" id="section_'.$data['key'].'" selector="section_data_'.$data['key'].'">'.$data['label'].'</div>';
						echo '<div class="td-accordiondata" id="section_data_'.$data['key'].'" style="display: none">';
							echo $function($data);
						echo '</div>';
				echo '</div>';
					
					endif;

				}else {
					//echo "function not found!";
				}
			}


		// echo "<pre>";
		// print_r($getFields);
		// echo "</pre>";

	endif;
	echo '<div class="total_amount" id="td_price">Totaal: <span class="td_prefix">€</span><span  class="td_number">0</span></div>';
	echo "<br>";
	echo '<div class="tdformsubmitbtn">';
	echo '<input type="submit" name="preview-submit" id="preview-button" value="Voorbeeld" style="margin-right: 20px;">';
	echo '<input type="submit" name="submit" id="checkout-button" value="Doorgaan">';
	echo '</div>';
	echo '</form>';
	echo '<div class="tdinvoice" id="tdinvoice">';
	?>	

	<?php
	echo '</div>';

	return ob_get_clean();
}