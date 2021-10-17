;(function($){
	var datainputprice = 0;
	var radioprice = 0;
	var tselect = 0;

	jQuery(document).ready(function($) {

    	$('#cityselectone').select2();
    	$('#cityselettwo').select2();


		function tdformprice(){
        var data = $('#tdfromfront').serialize();
  
	        $.post(taslimAjax.ajaxurl, data, function(response) {
	            if (response.success) {
	                console.log(response);
	            } else {
	                alert(response.data.message);
	            }
	        })
	        .fail(function() {
	            alert(taslimAjax.error);
	        })
		}


		function happyform(self = this){
			var tthis = self;
			var tallfield = document.querySelectorAll('[datainputprice]');

			var tloopn = 0;
			for (i = 0; i < tallfield.length; ++i) {
				var thisfield = tallfield[i]
				var inputtype = $(thisfield).attr( 'type');

				if ( $(thisfield).prop('checked') && (inputtype === 'checkbox' || inputtype === 'radio') ) {
					tloopn +=  ( $( thisfield ).attr( 'datainputprice') ) ? parseInt( $( thisfield ).attr( 'datainputprice') ) : 0;
				}

			}
			datainputprice = tloopn;

			var inputtype = $(tthis).attr( 'type');
			console.log(inputtype);
			console.log($(tthis));
			if (inputtype === 'selectfield') {
			 	tselect = parseInt( $('option:selected', tthis).attr('datainputprice') );
			}
			datainputprice += tselect;


			// var inputtype = $(this).attr( 'type');
			// if (inputtype === 'checkbox') {
			// 	if ( $(this).prop('checked') ) {
			// 		datainputprice +=  ( $( this ).attr( 'datainputprice') ) ? parseInt( $( this ).attr( 'datainputprice') ) : 0;
			// 	}else {
			// 		datainputprice -=  ( $( this ).attr( 'datainputprice') ) ? parseInt( $( this ).attr( 'datainputprice') ) : 0;
			// 	}	
			// }

			$('#td_price span.td_number').text(datainputprice)

		}


		$( "#cityselectone" ).change(function(e) {
			e.preventDefault();
			cityprice = parseInt( $('option:selected', this).attr('cityprice') );
			$('.tdf_'+taslimAjax.citypriceone+' .bp-cost').text(cityprice+' €') 
			$('[name="'+taslimAjax.citypriceone+'"]').attr('datainputprice', cityprice);
			$('[name="'+taslimAjax.citypriceone+'"]').val(cityprice);
			//$('#section_data_1').show();
		});

		$( "#cityselettwo" ).change(function(e) {
			e.preventDefault();
			const selectage = document.getElementById("select_tddate");
			const ageoption = $('option:selected', selectage).attr('age');

			const ccityprice = parseInt( $('option:selected', this).attr(ageoption) );
			cityprice = parseInt( $('option:selected', this).attr('cityprice') );

			$('.tdf_'+taslimAjax.citypricetwo+' .bp-cost').text(cityprice+' €') 
			$('[name="'+taslimAjax.citypricetwo+'"]').attr('datainputprice', cityprice);
			$('[name="'+taslimAjax.citypricetwo+'"]').val(cityprice);
			
			$('.tdf_'+taslimAjax.citycrematie+' .bp-cost').text(ccityprice+' €') 
			$('[name="'+taslimAjax.citycrematie+'"]').attr('datainputprice', ccityprice);
			$('[name="'+taslimAjax.citycrematie+'"]').val(ccityprice);
			//$('#section_data_1').show();
		});

		const select_tddate = document.getElementById("select_tddate");
		select_tddate.addEventListener('change', (event) => {
			event.preventDefault();
			const kistdiv = document.getElementById('select_tddate');
			const getKistPirce = kistdiv.options[kistdiv.selectedIndex].getAttribute('kistprice');
			if(getKistPirce){
				document.querySelector('.tdf_kist .bp-cost').innerText = getKistPirce+' €';
				document.querySelector('[name="kist"]').value = getKistPirce;
				document.getElementById('kist').value = getKistPirce;
				document.querySelector('[name="kist"]').setAttribute('datainputprice', getKistPirce);
			}
		});




		function taslimCallAjax() {
			var fdata = $('#tdfromfront').serialize();
			var data = fdata+'&action=td_from_price&_wpnonce='+taslimAjax.nonce;
	        $.post(taslimAjax.ajaxurl, data, function(response) {
	            if (response.success) {
	              //  console.log(response.data.message.file);
	                $(".td_number").text(response.data.message);
	               // $('.happytaslim_be_popup_form_content').html(response.data.message)
	            } else {
	                alert(response.data.message);
	            }
	        })
	        .fail(function() {
	            alert(taslimAjax.error);
	        })
		}
		//happyform();
		var cityprice = 0;
		var ptype = '';
		$( "#tdfromfront input, #tdfromfront select" ).change(function(e) {
			e.preventDefault();
			$(".td_number").text('00');

			var cityone = jQuery('[name="cityselectone"]').val();
			var citytwo = jQuery('[name="cityselettwo"]').val();
			var tddate = jQuery('[name="tddate"]').val();
			var get_ajax_price = jQuery('[name="get_ajax_price"]').val();
			console.log(citytwo, cityone)
			if( cityone == 0 || citytwo == 0 || tddate == '' || get_ajax_price == 0){
				return;
			}

			taslimCallAjax();

		});

		//start toggle
		$(".td-accordion").on("click", "", function(e) {
			e.preventDefault();
			jQuery('[name="get_ajax_price"]').val(1);
			var tdselector = $(this).attr('selector');
			$('#'+tdselector).toggle();
			$(this).toggleClass("tda-inactive");
			$(this).toggleClass("tda-active");
			taslimCallAjax();
		})

		//select date

		$.fn.datepicker.languages['nl-NL'] = {
		    format: 'dd-mm-yyyy',
		    days: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
		    daysShort: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
		    daysMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
		    weekStart: 1,
		    months: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
		    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
		  };

		$('[data-toggle="datepicker"]').datepicker({
			language: 'nl-NL',
			format: 'dd/mm/yyyy'
		});


    $('form#tdfromfront').on('click','#preview-button',function(e) {
        e.preventDefault();
        var fdata = $('#tdfromfront').serialize();
        var data = fdata+'&action=td_from_previw&_wpnonce='+taslimAjax.nonce;

        console.log(data);
        $('#tdformloader').show();
        $.post(taslimAjax.ajaxurl, data, function(response) {
            if (response.success) {
            	$('#tdformloader').hide();
                console.log(response);
				//const linkSource = `data:application/pdf;base64,${response.data.message.file}`;
                const downloadLink = document.createElement("a");
                const fileName = "funeral-"+ Date.now() +".pdf";
                downloadLink.href = response.data.message;
				downloadLink.target = '_blank';
               // downloadLink.download = fileName;
                downloadLink.click();
				
               // $('.happytaslim_be_popup_form_content').html(response.data.message)
            } else {
                alert(response.data.message);
            }
        })
        .fail(function() {
            alert(taslimAjax.error);
        })
    });


    $('form#tdfromfront').on('click','#checkout-button',function(e) {
        e.preventDefault();
        var fdata = $('#tdfromfront').serialize();
        var data = fdata+'&action=td_from_checkout&_wpnonce='+taslimAjax.nonce;

        console.log(data);
        $.post(taslimAjax.ajaxurl, data, function(response) {
            if (response.success) {
                console.log(response.data.message);
                window.location.href = response.data.message;
               // $('.happytaslim_be_popup_form_content').html(response.data.message)
            } else {
                alert(response.data.message);
            }
        })
        .fail(function() {
            alert(taslimAjax.error);
        })
    });

    $('.tdupload').on('change', function(e) {
        e.preventDefault();
        $('#loader').show('fast');
        var file_data = $(this).prop('files')[0];
        var form_data = new FormData();
        form_data.append('wecarry_file', file_data);
        form_data.append('action', 'wecarry_upload_file');
        form_data.append('_wpnonce', taslimAjax.nonce);
        var fileid = $(this).data('fileid');
        var imgsrc = $(this).data('imgsrc');
		$('.imageuplad span').text('Uploading...')
        $.ajax({
            url: taslimAjax.ajaxurl,
            type: 'POST',
            contentType: false,
            processData: false,
            data: form_data,
            success: function (response) {
                jQuery('.wecarryupload').val('');
                if (response.success) {
                    console.log(response);
                    $('.imageuplad span').text('Upload')
                    $('.'+imgsrc).attr('src',response.data.fileurl);
                    $('.'+fileid).val(response.data.fileid);
                    $('.custom_'+fileid).val(response.data.fileid);

                } else {
					$('.imageuplad span').text('Upload')
                }
            },
            error: function (response) {
             alert(taslimAjax.error);
            }
        });

    });



	});
})(jQuery)
