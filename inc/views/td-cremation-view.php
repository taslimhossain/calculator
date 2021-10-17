<div class="wrap taslim-formbuilder">
<h1 class="wp-heading-inline">Td Cremation form builder</h1>
<hr class="wp-header-end">

	<div class="widget-liquid-left">

		<ul id="form-fields">
	        <li><a href="#" class="button button-primary button-hero" field-type="title">Title</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="description">Description</a></li>
<!-- 	        <li><a href="#" class="button button-primary button-hero" field-type="text">Text</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="textarea">textarea</a></li> 
	        <li><a href="#" class="button button-primary button-hero" field-type="checkbox">checkbox</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="checkbox_price">checkbox pirce</a></li>-->
	        <li><a href="#" class="button button-primary button-hero" field-type="basic_service">Select Multiple Checkbox</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="radio_service">Select Single Checkbox</a></li>
	<!--         <li><a href="#" class="button button-primary button-hero" field-type="radio">Radio Buttons</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="radio_price">Radio button price </a></li> 
	        <li><a href="#" class="button button-primary button-hero" field-type="select">Select</a></li>-->
	        <li><a href="#" class="button button-primary button-hero" field-type="select_price">Select Dropdown</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="image">Select Image</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="image_price">Select Image with price</a></li>
	        <li><a href="#" class="button button-primary button-hero" field-type="poem">Select Text</a></li>
	    </ul>


	</div>
	<div class="widget-liquid-right">
		<div id="taslim_ajax_dispaly"></div>
		<form action="" method="post" id="form_fields_save">
			<div class="widgets-holder-wrap">
				<div id="taslim-sortable" class="widgets-sortables">

					<?php
					$getFields = stripslashes_deep(get_option( 'td_cremation_forms', true ));


					if (is_array($getFields) && count($getFields) != 0):
						foreach ($getFields as $key => $field) {
							echo getFieldHTML($field['type'], $key, $field);
						}
					endif;
					?>

					<?php //echo getFieldHTML('text', '50', $field=[]); ?>
				</div>

			<?php wp_nonce_field( 'form_fields_save' );?>
			<input type="hidden" name="formname" value="td_cremation">
			<input type="hidden" name="action" value="taslim_form_fields_save">
			<input type="submit" value="Save" class="button button-primary" style="margin: 10px;">
			</div>
		</form>
	</div>
	<br class="clear">
</div>