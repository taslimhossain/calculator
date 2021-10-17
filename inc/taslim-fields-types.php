<?php

function getFieldHTML($field_type, $field_id, $field=[]){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : $field_type;
	$fieldValue = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';

// echo "<pre>";
// print_r($field);
// echo "</pre>";

ob_start(); ?>
<div class="taslim-field" id="field-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
	<div class="taslim-row box-header">
		<div class="taslim-left">
			<button type="button" class="button button-primary collapse-btn" field-id="<?php echo $field_id; ?>" is-show="false"><span class="dashicons dashicons-arrow-down-alt2"></span></button>
			<span class="fieldlabeltext" style="font-size: 16px;line-height: 28px;margin-left: 10px;font-weight: 600;text-transform: capitalize;"><?php echo get_field_type_title($fieldType).':  <span>'.$fieldValue;?></span></span>
		</div>
		<div class="taslim-right">
			<button type="button" class="button button-primary remvoe-field" field-id="<?php echo $field_id; ?>"><span class="dashicons dashicons-trash"></span></button>		
		</div>
	</div>
	<?php 
		$function = 'taslim_'.$field_type;
		if(function_exists($function)) {
		  echo $function($field_id, $field);
		}else {
			echo "Sorry something error!";
		}
 	?>
</div>

<?php return ob_get_clean();
}

function taslim_title($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldValue = ( isset($field['value']) && !empty($field['value']) ) ? $field['value'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';
	ob_start(); ?>
	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][title][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][title][]" value="<?php echo $fieldValue; ?>" placeholder="title">

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][title][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}

function taslim_description($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldValue = ( isset($field['value']) && !empty($field['value']) ) ? $field['value'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';

	ob_start(); ?>
	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][description][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<textarea name="field[<?php echo $field_id; ?>][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldValue; ?></textarea>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][description][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}
function taslim_text($field_id, $field){

	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	ob_start(); ?>
	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][text][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][text][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][text][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][text][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<p><label class="switch">
			<span class="label">Required field</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][text][required][]" <?php echo checked( $fieldRequired, 'checked', false ); ?> >
		  <span class="slider round"></span>
		</label></p>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][text][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}

function taslim_textarea($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][textarea][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][textarea][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][textarea][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][textarea][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<p><label class="switch">
			<span class="label">Required field</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][textarea][required][]" <?php echo checked( $fieldRequired, 'checked', false ); ?> >
		  <span class="slider round"></span>
		</label></p>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][textarea][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}

function taslim_checkbox($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][checkbox][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][checkbox][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][checkbox][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][checkbox][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][checkbox][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][checkbox][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][checkbox][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][checkbox][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
			<span class="label">Required field</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][checkbox][required][]" <?php echo checked( $fieldRequired, 'checked', false ); ?> >
		  <span class="slider round"></span>
		</label></p>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][checkbox][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}


function taslim_radio($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][radio][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][radio][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][radio][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][radio][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][radio][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][radio][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][radio][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][radio][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
			<span class="label">Required field</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][radio][required][]" <?php echo checked( $fieldRequired, 'checked', false ); ?> >
		  <span class="slider round"></span>
		</label></p>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][radio][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}

function taslim_select($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][select][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][select][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][select][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][select][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][select][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][select][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][select][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][select][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
			<span class="label">Required field</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][select][required][]" <?php echo checked( $fieldRequired, 'checked', false ); ?> >
		  <span class="slider round"></span>
		</label></p>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][select][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>
	</div>
	<?php return ob_get_clean();
}

function taslim_image($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	$fieldcustom_image = ( isset($field['custom_image']) && !empty($field['custom_image']) ) ? $field['custom_image'] : '';	
	$fieldCondition = ( isset($field['condition']) && !empty($field['condition']) ) ? $field['condition'] : '';
	$fieldConditionvalue = ( isset($field['conditionvalue']) && !empty($field['conditionvalue']) ) ? $field['conditionvalue'] : '';
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][image][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][image][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][image][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][image][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Images</th>
                    <th>Title</th>
                    <th>Tekst 1</th>
                    <th>Tekst 2</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
				$tdimg = wp_get_attachment_image_src( $value['key'] );
			?>
	            <tr>
	                <td>

     
	                	<div class="taslim-img-upload">
	                		<span class="button button-primary">Upload image</span>
	                		<img src="<?php echo $tdimg[0]; ?>" class="product_imgurl" style="width: 60px; display: inline-block; margin-top: -15px;">
	                		<input type="hidden" name="field[<?php echo $field_id; ?>][image][optionlabel][]" value="<?php echo $value['key']; ?>"  placeholder="Field Label" class="product_img">
	                	</div>

	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][image][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][image][optiondescription][]" value="<?php echo $value['optiondescription']; ?>" placeholder="Input description" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][image][optiondescriptiontwo][]" value="<?php echo $value['optiondescriptiontwo']; ?>" placeholder="Input description" class="form-control input-md">
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                	<div class="taslim-img-upload">
                		<span class="button button-primary">Upload image</span>
                		<img src="" class="product_imgurl" style="width: 60px; display: inline-block; margin-top: -15px;">
                		<input type="hidden" name="field[<?php echo $field_id; ?>][image][optionlabel][]" value=""  placeholder="Field Label" class="product_img">
                	</div>
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][image][optionvalue][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][image][optiondescription][]" value="" placeholder="Input description" class="form-control input-md">
                </td>  
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][image][optiondescriptiontwo][]" value="" placeholder="Input description" class="form-control input-md">
                </td>                
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][image][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

		<p><label class="switch">
		  <span class="label">Allow to upload custom image</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][image][custom_image][]" <?php echo checked( $fieldcustom_image, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

		<table class="table taslim-table condition-table">
            <thead>
                <tr>
                    <th>Select field</th>
                    <th>Value</th>
                </tr>
            </thead>
        	<tbody>
        		<tr>
        			<td>
        				
        				<select name="field[<?php echo $field_id; ?>][image][condition][]" class="condition-select">
        					<option value="0">Select field</option>
        					<option value="<?php echo $fieldCondition; ?>" selected ><?php echo $fieldCondition; ?></option>
        				</select>
        			</td>
        			<td><input type="text" name="field[<?php echo $field_id; ?>][image][conditionvalue][]" value="<?php echo $fieldConditionvalue; ?>"></td>
        		</tr>
        	</tbody>
        </table>

	</div>
	<?php return ob_get_clean();
}

//----------------
function taslim_checkbox_price($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	ob_start(); ?>
	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][checkbox_price][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][checkbox_price][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][checkbox_price][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][checkbox_price][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>Price</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][checkbox_price][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][checkbox_price][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][checkbox_price][optionprice][]" value="<?php echo $value['price']; ?>" placeholder="Input Price" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][checkbox_price][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][checkbox_price][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][checkbox_price][optionprice][]"  placeholder="Input Price" class="form-control input-md">                                	
                </td>                
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][checkbox_price][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}


function taslim_radio_price($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][radio_price][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][radio_price][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][radio_price][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][radio_price][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>Price</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][radio_price][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][radio_price][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
					<td>
					    <input type="text" name="field[<?php echo $field_id; ?>][radio_price][optionprice][]" value="<?php echo $value['price']; ?>"  placeholder="Input Price" class="form-control input-md">                                	
					</td> 	                
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][radio_price][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][radio_price][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][radio_price][optionprice][]"  placeholder="Input Price" class="form-control input-md">                                	
                </td>                 
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>
		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][radio_price][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

	</div>
	<?php return ob_get_clean();
}


function taslim_select_price($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';
	$fieldCondition = ( isset($field['condition']) && !empty($field['condition']) ) ? $field['condition'] : '';
	$fieldConditionvalue = ( isset($field['conditionvalue']) && !empty($field['conditionvalue']) ) ? $field['conditionvalue'] : '';
	
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][select_price][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][select_price][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][select_price][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][select_price][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>Price</th>
                    <th style="width: 80px;">Tax</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][select_price][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][select_price][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][select_price][optionprice][]"  value="<?php echo $value['price']; ?>" placeholder="Input Price" class="form-control input-md">                                	
	                </td> 
					<td>
					    <input type="text" name="field[<?php echo $field_id; ?>][select_price][optiontax][]" value="<?php echo $value['tax']; ?>" placeholder="Input tax" class="form-control input-md" style="width: 80px;">
					</td>	                                
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][select_price][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][select_price][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][select_price][optionprice][]"  placeholder="Input Price" class="form-control input-md">        
                </td>      
				<td>
				    <input type="text" name="field[<?php echo $field_id; ?>][basic_service][optiontax][]"  placeholder="Input Price" class="form-control input-md" style="width: 80px;">         	
				</td>                             
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][select_price][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

        <table class="table taslim-table condition-table">
            <thead>
                <tr>
                    <th>Select field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        
                        <select name="field[<?php echo $field_id; ?>][select_price][condition][]" class="condition-select">
                            <option value="0">Select field</option>
                            <option value="<?php echo $fieldCondition; ?>" selected ><?php echo $fieldCondition; ?></option>
                        </select>
                    </td>
                    <td><input type="text" name="field[<?php echo $field_id; ?>][select_price][conditionvalue][]" value="<?php echo $fieldConditionvalue; ?>"></td>
                </tr>
            </tbody>
        </table>

	</div>
	<?php return ob_get_clean();
}



function taslim_poem($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	

	$fieldCondition = ( isset($field['condition']) && !empty($field['condition']) ) ? $field['condition'] : '';
	$fieldConditionvalue = ( isset($field['conditionvalue']) && !empty($field['conditionvalue']) ) ? $field['conditionvalue'] : '';

	
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][poem][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][poem][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][poem][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][poem][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Text</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][poem][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                	<textarea name="field[<?php echo $field_id; ?>][poem][optionvalue][]" id="" class="form-control input-md" cols="30" rows="10"><?php echo $value['value']; ?></textarea>                                	
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][poem][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                	<textarea name="field[<?php echo $field_id; ?>][poem][optionvalue][]" id="" class="form-control input-md" cols="30" rows="5"></textarea>                              	
                </td>
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][poem][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

        <table class="table taslim-table condition-table">
            <thead>
                <tr>
                    <th>Select field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="field[<?php echo $field_id; ?>][poem][condition][]" class="condition-select">
                            <option value="0">Select field</option>
                            <option value="<?php echo $fieldCondition; ?>" selected ><?php echo $fieldCondition; ?></option>
                        </select>
                    </td>
                    <td><input type="text" name="field[<?php echo $field_id; ?>][poem][conditionvalue][]" value="<?php echo $fieldConditionvalue; ?>"></td>
                </tr>
            </tbody>
        </table>


	</div>
	<?php return ob_get_clean();
}

//----------------
function taslim_basic_service($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';	

	$fieldCondition = ( isset($field['condition']) && !empty($field['condition']) ) ? $field['condition'] : '';
	$fieldConditionvalue = ( isset($field['conditionvalue']) && !empty($field['conditionvalue']) ) ? $field['conditionvalue'] : '';

	ob_start(); ?>
	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][basic_service][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][basic_service][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName">
		<input type="text" name="field[<?php echo $field_id; ?>][basic_service][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][basic_service][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th style="width: 80px;">Price</th>
                    <th style="width: 80px;">Tax</th>
                    <th>Checked</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][basic_service][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][basic_service][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                	<textarea name="field[<?php echo $field_id; ?>][basic_service][optiondescription][]" id="" class="form-control input-md" cols="30" rows="6"><?php echo $value['optiondescription']; ?></textarea>                            	
	                </td>	                
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][basic_service][optionprice][]" value="<?php echo $value['price']; ?>" placeholder="Input Price" class="form-control input-md" style="width: 80px;">                                	
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][basic_service][optiontax][]" value="<?php echo $value['tax']; ?>" placeholder="Input tax" class="form-control input-md" style="width: 80px;">                                	
	                </td>	                
	                <td>
		                <select name="field[<?php echo $field_id; ?>][basic_service][optionshow][]" id="">
		                	<option value="no" <?php selected( $value['optionshow'], 'on' );?>>Not Fixed price</option>
		                	<option value="on" <?php selected( $value['optionshow'], 'on' );?>>Fixed price</option>
		                </select>		               	
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][basic_service][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][basic_service][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                	<textarea name="field[<?php echo $field_id; ?>][basic_service][optiondescription][]" id="" class="form-control input-md" rows="2"></textarea>                            	
                </td>                  
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][basic_service][optionprice][]"  placeholder="Input Price" class="form-control input-md" style="width: 80px;">          	
                </td>                  
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][basic_service][optiontax][]"  placeholder="Input Price" class="form-control input-md" style="width: 80px;">         	
                </td>              
                <td>
	                <select name="field[<?php echo $field_id; ?>][basic_service][optionshow][]" id="">
	                	<option value="no">Not Fixed price</option>
	                	<option value="on">Fixed price</option>
	                </select>
                </td>                               
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][basic_service][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

		<table class="table taslim-table condition-table">
            <thead>
                <tr>
                    <th>Select field</th>
                    <th>Value</th>
                </tr>
            </thead>
        	<tbody>
        		<tr>
        			<td>
        				
        				<select name="field[<?php echo $field_id; ?>][basic_service][condition][]" class="condition-select">
        					<option value="0">Select field</option>
        					<option value="<?php echo $fieldCondition; ?>" selected ><?php echo $fieldCondition; ?></option>
        				</select>
        			</td>
        			<td><input type="text" name="field[<?php echo $field_id; ?>][basic_service][conditionvalue][]" value="<?php echo $fieldConditionvalue; ?>"></td>
        		</tr>
        	</tbody>
        </table>

	</div>
	<?php return ob_get_clean();
}

//----------------
function taslim_radio_service($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';

	$fieldCondition = ( isset($field['condition']) && !empty($field['condition']) ) ? $field['condition'] : '';
	$fieldConditionvalue = ( isset($field['conditionvalue']) && !empty($field['conditionvalue']) ) ? $field['conditionvalue'] : '';
	
	ob_start(); ?>
	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][radio_service][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][radio_service][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][radio_service][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][radio_service][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>Price</th>
                    <th style="width: 80px;">Tax</th>
                    <th>Description</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
	            <tr>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][radio_service][optionlabel][]" value="<?php echo $value['key']; ?>" placeholder="Field Label" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][radio_service][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">                                	
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][radio_service][optionprice][]" value="<?php echo $value['price']; ?>" placeholder="Input Price" class="form-control input-md">                                	
	                </td>
					<td>
					    <input type="text" name="field[<?php echo $field_id; ?>][radio_service][optiontax][]" value="<?php echo $value['tax']; ?>" placeholder="Input tax" class="form-control input-md" style="width: 80px;">
					</td>	                
	                <td>
	                	<textarea name="field[<?php echo $field_id; ?>][radio_service][optiondescription][]" id="" class="form-control input-md" cols="30" rows="10"><?php echo $value['optiondescription']; ?></textarea>                            	
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                    <input name="field[<?php echo $field_id; ?>][radio_service][optionlabel][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][radio_service][optionvalue][]" type="text" placeholder="Input Name" class="form-control input-md">                                	
                </td>
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][radio_service][optionprice][]"  placeholder="Input Price" class="form-control input-md">                                	
                </td>
				<td>
				    <input type="text" name="field[<?php echo $field_id; ?>][radio_service][optiontax][]"  placeholder="Input Price" class="form-control input-md" style="width: 80px;">         	
				</td>                 
                <td>
                	<textarea name="field[<?php echo $field_id; ?>][radio_service][optiondescription][]" id="" class="form-control input-md" rows="2"></textarea>                            	
                </td>
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>           
            </tbody>
        </table>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][radio_service][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>


		<table class="table taslim-table condition-table">
            <thead>
                <tr>
                    <th>Select field</th>
                    <th>Value</th>
                </tr>
            </thead>
        	<tbody>
        		<tr>
        			<td>
        				
        				<select name="field[<?php echo $field_id; ?>][radio_service][condition][]" class="condition-select">
        					<option value="0">Select field</option>
        					<option value="<?php echo $fieldCondition; ?>" selected ><?php echo $fieldCondition; ?></option>
        				</select>
        			</td>
        			<td><input type="text" name="field[<?php echo $field_id; ?>][radio_service][conditionvalue][]" value="<?php echo $fieldConditionvalue; ?>"></td>
        		</tr>
        	</tbody>
        </table>

	</div>
	<?php return ob_get_clean();
}

function taslim_image_price($field_id, $field){
	$fieldType = ( isset($field['type']) && !empty($field['type']) ) ? $field['type'] : '';
	$fieldName = ( isset($field['name']) && !empty($field['name']) ) ? $field['name'] : '';
	$fieldLabel = ( isset($field['label']) && !empty($field['label']) ) ? $field['label'] : '';
	$fieldTitle = ( isset($field['title']) && !empty($field['title']) ) ? $field['title'] : '';
	$fieldDescription = ( isset($field['description']) && !empty($field['description']) ) ? $field['description'] : '';
	$fieldOptions = ( isset($field['options']) && !empty($field['options']) ) ? $field['options'] : '';
	$fieldRequired = ( isset($field['required']) && !empty($field['required']) ) ? $field['required'] : '';
	$fieldShow = ( isset($field['show']) && !empty($field['show']) ) ? $field['show'] : '';
	$fieldCondition = ( isset($field['condition']) && !empty($field['condition']) ) ? $field['condition'] : '';
	$fieldConditionvalue = ( isset($field['conditionvalue']) && !empty($field['conditionvalue']) ) ? $field['conditionvalue'] : '';
	ob_start(); ?>

	<div class="taslim-row fieldelement" id="fieldelement-<?php echo $field_id; ?>" row-id="<?php echo $field_id; ?>">
		<input type="text" name="field[<?php echo $field_id; ?>][image_price][label][]" value="<?php echo $fieldLabel; ?>" placeholder="Label" class="taslimLabel">
		<input type="text" name="field[<?php echo $field_id; ?>][image_price][name][]" value="<?php echo $fieldName; ?>" placeholder="Name" class="taslimName timcondition">
		<input type="text" name="field[<?php echo $field_id; ?>][image_price][title][]" value="<?php echo $fieldTitle; ?>" placeholder="Title">
		<textarea name="field[<?php echo $field_id; ?>][image_price][description][]" cols="30" rows="5" placeholder="Description"><?php echo $fieldDescription; ?></textarea>

		<table class="table table-striped taslim-table">
            <thead>
                <tr>
                    <th>Images</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Tax</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        	<tbody>

			<?php
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
				$tdimg = wp_get_attachment_image_src( $value['key'] );
			?>
	            <tr>
	                <td>


	                	<div class="taslim-img-upload">
	                		<span class="button button-primary">Upload image</span>
	                		<img src="<?php echo $tdimg[0]; ?>" class="product_imgurl" style="width: 60px; display: inline-block; margin-top: 0px;">
	                		<input type="hidden" name="field[<?php echo $field_id; ?>][image_price][optionlabel][]" value="<?php echo $value['key']; ?>"  placeholder="Field Label" class="product_img">
	                	</div>

	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][image_price][optionvalue][]" value="<?php echo $value['value']; ?>" placeholder="Input Name" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][image_price][optionprice][]" value="<?php echo $value['price']; ?>" placeholder="Price" class="form-control input-md">
	                </td>
	                <td>
	                    <input type="text" name="field[<?php echo $field_id; ?>][image_price][optiontax][]" value="<?php echo $value['tax']; ?>" placeholder="Tax" class="form-control input-md">
	                </td>
	                <td>
	                    <a href="#" class="button button-primary form-add-row">+</a>
	                    <a href="#" class="button button-primary remove-row">-</a>
	                </td>
	            </tr>
			<?php
			endforeach;
			endif;
			?>
            <tr>
                <td>
                	<div class="taslim-img-upload">
                		<span class="button button-primary">Upload image</span>
                		<img src="" class="product_imgurl" style="width: 60px; display: inline-block; margin-top: -15px;">
                		<input type="hidden" name="field[<?php echo $field_id; ?>][image_price][optionlabel][]" value=""  placeholder="Field Label" class="product_img">
                	</div>
                </td>
                <td>
                    <input name="field[<?php echo $field_id; ?>][image_price][optionvalue][]" type="text" placeholder="Field Label" class="form-control input-md">
                </td>
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][image_price][optionprice][]" value="" placeholder="Input description" class="form-control input-md">
                </td>
                <td>
                    <input type="text" name="field[<?php echo $field_id; ?>][image_price][optiontax][]" value="" placeholder="Input description" class="form-control input-md">
                </td>
                <td>
                    <a href="#" class="button button-primary form-add-row">+</a>
                    <a href="#" class="button button-primary remove-row">-</a>
                </td>
            </tr>
            </tbody>
        </table>

		<p><label class="switch">
		  <span class="label">Hide in submit form</span>
		  <input type="checkbox" name="field[<?php echo $field_id; ?>][image_price][show][]" <?php echo checked( $fieldShow, 'checked', false ); ?>>
		  <span class="slider round"></span>
		</label></p>

		<table class="table taslim-table condition-table">
            <thead>
                <tr>
                    <th>Select field</th>
                    <th>Value</th>
                </tr>
            </thead>
        	<tbody>
        		<tr>
        			<td>

        				<select name="field[<?php echo $field_id; ?>][image_price][condition][]" class="condition-select">
        					<option value="0">Select field</option>
        					<option value="<?php echo $fieldCondition; ?>" selected ><?php echo $fieldCondition; ?></option>
        				</select>
        			</td>
        			<td><input type="text" name="field[<?php echo $field_id; ?>][image_price][conditionvalue][]" value="<?php echo $fieldConditionvalue; ?>"></td>
        		</tr>
        	</tbody>
        </table>

	</div>
	<?php return ob_get_clean();
}