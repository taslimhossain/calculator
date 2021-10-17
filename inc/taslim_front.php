<?php

/**
 * add title function
*/

function taslim_front_title($data){
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<?php echo (isset($data['label']) && !empty($data['label'])) ? '<h2>'.$data['label'].'</h2>' : ''; ?>
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_description($data){
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<?php echo (isset($data['label']) && !empty($data['label'])) ? '<p>'.$data['label'].'</p>' : ''; ?>
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_text($data){
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
	    <label for="field_<?php echo $data['name']; ?>"><?php echo $data['label']; ?></label>
	    <input type="text" name="<?php echo $data['name']; ?>" class="form-control" id="field_<?php echo $data['name']; ?>" placeholder="<?php echo $data['label']; ?>" <?php echo $data['required']; ?>>
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_textarea($data){
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
	    <label for="field_<?php echo $data['name']; ?>"><?php echo $data['label']; ?></label>
	    <textarea name="<?php echo $data['name']; ?>" id="field_<?php echo $data['name']; ?>" cols="30" rows="5" placeholder="<?php echo $data['label']; ?>" <?php echo $data['required']; ?>></textarea>
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_checkbox($data){
	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>

			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
		    <label class="tdcheckbox single-checkout">
		    	<input type="checkbox" class="form-check-input" name="<?php echo $value['value']; ?>" value="<?php echo $value['key']; ?>"> 
		    	<span class="checkmark"></span>
		    	<span class="ctitle"><?php echo $value['key']; ?></span>
		    </label>
			<?php
			endforeach;
			endif;
			?>	    
	    
	</div>
	<?php
	return ob_get_clean();
}


function taslim_front_radio($data){
	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
		<p class="radiolable"><?php echo $data['label']; ?></p>
			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
		    <label class="tdcheckbox single-checkout">
		    	<input type="radio" class="form-check-input" name="<?php echo $data['name']; ?>" value="<?php echo $value['key'];?>" > 
		    	<span class="checkmark"></span>
		    	<span class="ctitle"><?php echo $value['key']; ?></span>
		    </label>
			<?php
			endforeach;
			endif;
			?>	    
	    
	</div>
	<?php
	return ob_get_clean();
}


function taslim_front_select($data){
	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
		<label for="<?php echo $data['name']; ?>"><?php echo $data['label']; ?></label>
		<select name="<?php echo $data['name']; ?>" id="<?php echo $data['name']; ?>">
			<?php 
				if (is_array($fieldOptions) && count($fieldOptions) != 0) :
				foreach ($fieldOptions as $value):
				?>
				<option value="<?php echo $value['key']; ?>"><?php echo $value['key']; ?></option>
				<?php
				endforeach;
				endif;
			?>	    
	    </select>
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_select_price($data){
	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
		<label for="<?php echo $data['name']; ?>"><?php echo $data['label']; ?></label>
		<select name="<?php echo $data['name']; ?>" id="<?php echo $data['name']; ?>" type="selectfield">
			<option value="0" datainputprice="0">Selecteer opties</option>
			<?php 
				if (is_array($fieldOptions) && count($fieldOptions) != 0) :
				foreach ($fieldOptions as $value):
				?>
				<option value="<?php echo $value['key']; ?>" type="select" datainputprice="<?php echo $value['price']; ?>"><?php echo $value['key']; ?> - €<?php echo $value['price']; ?></option>
				<?php
				endforeach;
				endif;
			?>	    
	    </select>
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_checkbox_price($data){
	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
		<p class="checkboxlable"><?php echo $data['label']; ?></p>
			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
		    <label class="tdcheckbox single-checkout">
		    	<input type="checkbox" class="form-check-input" name="<?php echo $value['value']; ?>" value="<?php echo $value['key']; ?>" datainputprice="<?php echo $value['price']; ?>"> 
				<span class="checkmark"></span>
		    	<span class="ctitle"><?php echo $value['key']; ?></span>
		    </label>
			<?php
			endforeach;
			endif;
			?>
	</div>
	<?php
	return ob_get_clean();
}


function taslim_front_radio_price($data){


	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
		<p class="radiolable"><?php echo $data['label']; ?></p>
			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
		    <label class="tdcheckbox single-checkout">
		    	<input type="radio" class="form-check-input" name="<?php echo $data['name']; ?>" value="<?php echo $value['key'];?>" datainputprice="<?php echo $value['price']; ?>">
		    	<span class="checkmark"></span>
		    	<span class="ctitle"><?php echo $value['key']; ?></span>
		    </label>
			<?php
			endforeach;
			endif;
			?>	    
	    
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_image($data){
	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';

	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
			<div class="tdpoemarea">
				<?php 
				if (is_array($fieldOptions) && count($fieldOptions) != 0) :
				foreach ($fieldOptions as $value):
				$tdimg = wp_get_attachment_image_src( $value['key'], 'full' );
				?>
			    <label class="tdselectpoem tdcheckbox" for="<?php echo $data['name'].'_'.$value['key'];?>">
			    	<img src="<?php echo (isset($tdimg[0])) ? $tdimg[0] : '' ; ?>" class="product_imgurl">
			    	<p class="tdimges"><?php echo $value['value']; ?></p>
			    	<p class="tdimgesdescription">
			    		<?php echo (isset($value['optiondescription']) && $value['optiondescription'] != 'click') ? $value['optiondescription'] : ''; ?>
			    		<?php echo (isset($value['optiondescriptiontwo']) && !empty($value['optiondescriptiontwo'])) ? '<br>' : ''; ?>
			    		<?php echo $value['optiondescriptiontwo']; ?>
			    	</p>
			    	<?php $imgfieldvalue = (isset($value['optiondescription']) && $value['optiondescription'] == 'click') ? 'click' : $value['key']; ?>
			    	<input type="radio" class="form-check-input" name="<?php echo $data['name']; ?>" value="<?php echo $imgfieldvalue; ?>" id="<?php echo $data['name'].'_'.$value['key'];?>">
				    	<span class="checkmark"></span>
				    	<span class="tdselectstatus kies">Uw keuze</span>
				    	<span class="tdselectstatus keuze">Kies</span>		    	
			    </label>

				<?php
				endforeach;
				endif;
				?>
				<?php if($data['custom_image'] === 'checked'): ?>
			    <label class="tdselectpoem tdcheckbox custom_img" data-filedname="<?php echo $data['name']; ?>" for="<?php echo $data['type'].'_'.$data['name']; ?>">
			    	<img src="<?php echo TDPLUGINDIR.'images/upload.png'?>" class="<?php echo $data['type'].'_'.$data['name']; ?>_preview">
			    	<p class="tdimges">upload je foto</p>
					<label for="<?php echo $data['type'].'_'.$data['name']; ?>upload" class="imageuplad">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z"/><path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/></svg> <span>Upload</span>
					</label>
					<input type="file" name="profilepic" data-imgsrc="<?php echo $data['type'].'_'.$data['name']; ?>_preview" data-fileid="<?php echo $data['type'].'_'.$data['name']; ?>_field" class="tdupload" id="<?php echo $data['type'].'_'.$data['name']; ?>upload" style="display: none;">

			    	<input type="radio" class="form-check-input upload_custom_img <?php echo $data['type'].'_'.$data['name']; ?>_field" name="<?php echo $data['name']; ?>" value="" id="<?php echo $data['type'].'_'.$data['name']; ?>">
			    	<input type="hidden" class="custom_<?php echo $data['type'].'_'.$data['name']; ?>_field" name="<?php echo $data['name']; ?>['custom']" value="">

				    	<span class="checkmark"></span>
				    	<span class="tdselectstatus kies">Uw keuze</span>
				    	<span class="tdselectstatus keuze">Kies</span>		    	
			    </label>

				

				<?php endif; ?>


		</div>
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_poem($data){

	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?> </h4>
		<p class="description"><?php echo $data['description']; ?></p>
			<div class="tdpoemarea">
				<?php 
				if (is_array($fieldOptions) && count($fieldOptions) != 0) :
				foreach ($fieldOptions as $value):
				?>

			    <label class="tdselectpoem tdcheckbox" for="<?php echo $data['name']; ?>_<?php echo $value['key'];?>">
			    	<p> <span class="poem-title"><?php echo $value['key']; ?></span> <br><?php echo $value['value']; ?></p>
			    	<input type="radio" class="form-check-input radio_poem" name="<?php echo $data['name']; ?>" value="<?php echo $value['key'];?>" id="<?php echo $data['name']; ?>_<?php echo $value['key'];?>">
			    	<span class="checkmark"></span>
			    	<span class="tdselectstatus kies">Kies</span>
			    	<span class="tdselectstatus keuze">Uw keuze</span>
			    </label>
				<?php
				endforeach;
				endif;
				?>



				<label class="tdselectpoem tdcheckbox" for="<?php echo $data['name']; ?>_custompoem">
			    	<p> <span class="poem-title">Je eigen gedicht</span> </p>
			    	<input type="radio" class="form-check-input radio_poem" name="<?php echo $data['name']; ?>" value="custompoem" id="<?php echo $data['name']; ?>_custompoem">
			    	<span class="checkmark"></span>
			    	<span class="tdselectstatus kies">Kies</span>
			    	<span class="tdselectstatus keuze">Uw keuze</span>
			    </label>
				<textarea name="<?php echo $data['name']; ?>['custom']" id="<?php echo $data['name']; ?>_custompoem" class="tdcustompoem <?php echo $data['name'].'_cpoemtextarea'; ?>" cols="30" rows="3" style="display:none;" placeholder="Schrijf hier je eigen gedicht" ></textarea>

			</div>
	</div>

	<script>
	jQuery('.radio_poem').change(function(){
		console.log(jQuery(this).val())
		if(jQuery(this).val() === 'custompoem'){
			jQuery('.<?php echo $data['name'].'_cpoemtextarea'; ?>').show();
		} else {
			jQuery('.<?php echo $data['name'].'_cpoemtextarea'; ?>').hide();
		}
	});
	</script>
	<?php
	return ob_get_clean();
}


function taslim_front_basic_service($data){

	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>

		
			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
		<div class="basic-pakage tdf_<?php echo $value['value']; ?>">
			<div class="bp-row">
				<div class="bp-title"><p><?php echo $value['key']; ?></p></div>
				<div class="bp-price">
					<p>
					<span class="bp-cost"><?php echo $value['price']; ?> €</span>
					<span>
						<label class="tdcheckbox">
							<input type="checkbox" class="form-check-input" name="<?php echo $value['value']; ?>" value="<?php echo $value['key']; ?>" datainputprice="<?php echo $value['price']; ?>" <?php echo checked( $value['optionshow'], 'on', false ); ?>   <?php echo (!empty($value['optionshow']) && $value['optionshow'] === 'on')? 'disabled="disabled"' : '' ?> <?php echo (!empty($value['optionshow']) && $value['optionshow'] != 'on')? 'notchange="disabled"' : '' ?> >
							<span class="checkmark"></span>

							<?php if(!empty($value['optionshow']) && $value['optionshow'] === 'on'): ?>
								<input type="hidden" id="<?php echo $value['value']; ?>" name="<?php echo $value['value']; ?>" value="<?php echo $value['key']; ?>" />
							<?php endif; ?>
						</label>
					</span>
					</p>		
				</div>				
			</div>
			<div class="bp-row">
				<p><?php echo $value['optiondescription']; ?></p>
			</div>
		</div>
			<?php
			endforeach;
			endif;
			?>
			
	</div>
	<?php
	return ob_get_clean();
}


function taslim_front_radio_service($data){

	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>

		
			<?php 
			if (is_array($fieldOptions) && count($fieldOptions) != 0) :
			foreach ($fieldOptions as $value):
			?>
		<div class="basic-pakage tdf_<?php echo $value['value']; ?>">
			<div class="bp-row">
				<div class="bp-title"><p><?php echo $value['key']; ?></p></div>
				<div class="bp-price">
					<p>
					<span class="bp-cost"><?php echo $value['price']; ?> €</span>
					<span>
						<label class="tdcheckbox">
							<input type="radio" class="form-check-input" name="<?php echo $data['name']; ?>" value="<?php echo $value['key']; ?>" datainputprice="<?php echo $value['price']; ?>" <?php echo checked( $value['optionshow'], 'on', false ); ?>   <?php echo (!empty($value['optionshow']) && $value['optionshow'] === 'on')? 'disabled="disabled"' : '' ?> >
							<span class="checkmark"></span>
						</label>
					</span>
					</p>		
				</div>				
			</div>
			<div class="bp-row">
				<p><?php echo $value['optiondescription']; ?></p>
			</div>
		</div>
			<?php
			endforeach;
			endif;
			?>
			
	</div>
	<?php
	return ob_get_clean();
}

function taslim_front_image_price($data){

	$fieldOptions = ( isset($data['options']) && !empty($data['options']) ) ? $data['options'] : '';
	ob_start();
	?>
	<div class="tdform td_<?php echo $data['type']; ?>">
		<h4 class="title"><?php echo $data['title']; ?></h4>
		<p class="description"><?php echo $data['description']; ?></p>
			<div class="tdpoemarea">
				<?php 
				if (is_array($fieldOptions) && count($fieldOptions) != 0) :
				foreach ($fieldOptions as $value):
				$tdimg = wp_get_attachment_image_src( $value['key'], 'full' );
// echo "<pre>";
// print_r($value);
// echo "</pre>";
				?>
			    <label class="tdselectpoem tdcheckbox" for="<?php echo $data['name']; ?>_<?php echo $value['key'];?>">
			    	<img src="<?php echo $tdimg[0]; ?>" class="product_imgurl">
			    	<p class="tdimges"><?php echo $value['value']; ?></p>
			    	<p class="tdimgesprice">€<?php echo $value['price']; ?></p>
			    	<p class="tdimgesdescription">
			    		<?php echo (isset($value['optiondescription']) && $value['optiondescription'] != 'click') ? $value['optiondescription'] : ''; ?>
			    		<?php echo (isset($value['optiondescriptiontwo']) && !empty($value['optiondescriptiontwo'])) ? '<br>' : ''; ?>
			    		<?php echo $value['optiondescriptiontwo']; ?>
			    	</p>
			    	<?php $imgfieldvalue = (isset($value['optiondescription']) && $value['optiondescription'] == 'click') ? 'click' : $value['key']; ?>
			    	<input type="radio" class="form-check-input" name="<?php echo $data['name']; ?>" value="<?php echo $imgfieldvalue; ?>" id="<?php echo $data['name']; ?>_<?php echo $value['key'];?>">
				    	<span class="checkmark"></span>
				    	<span class="tdselectstatus kies">Uw keuze</span>
				    	<span class="tdselectstatus keuze">Kies</span>		    	
			    </label>

				<?php
				endforeach;
				endif;
				?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}