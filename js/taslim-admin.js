;(function($){
   console.log('Load........');


var tfieldName = document.querySelectorAll('.timcondition');
console.log(tfieldName);

tfieldName.forEach(function(fname){
    console.log(fname);
    console.log(fname.value);

    $('.condition-select').append(
        $('<option>', { 
            value: fname.value,
            text : fname.value 
        })
    );

})


 // $( '#taslim-sortable' ).on( 'click', '.cfixepirce input', function() {


 //    console.log($(this).val());
 //    if ($(this).val() == 'on') {
 //        $(this).val('off')
 //    }else{
 //        $(this).val('on')
 //    }
 //    console.log('okay');
 // });

//------------------------------------------
    $( '#taslim-sortable' ).on( 'click', '.remvoe-field', function() {
        var field_id = $( this ).attr( 'field-id');
        $( '#field-'+field_id ).remove();
    });

    $( '#taslim-sortable' ).on( 'click', '.collapse-btn', function() {
        var field_id = $( this ).attr( 'field-id');
        var is_show = $( this ).attr( 'is-show');
        if (is_show === 'true') {
            $( this ).attr( 'is-show', 'false' );
            $( this).find("span").attr('class', 'dashicons dashicons-arrow-down-alt2');
            $( '#fieldelement-'+field_id ).hide('slow');
        }else{
            $( this ).attr( 'is-show', 'true' );
            $( this).find("span").attr('class', 'dashicons dashicons-arrow-up-alt2');
            $( '#fieldelement-'+field_id ).show('slow');
        }

    });


    $("#form-fields").on("click", "li a", function(e) {
        e.preventDefault();
        var field_type = $( this ).attr( 'field-type');
        var last_id = document.getElementsByClassName('taslim-field');
        var field_row = last_id.length+1;

        var data = {
            'field_type' : field_type,
            'field_row' : field_row,
            '_wpnonce' : taslimAjax.nonce,
            'action' : 'taslim_create_fields'
        }
        $.post(taslimAjax.ajaxurl, data, function(response) {
            if (response.success) {
                console.log(response);
                $("#taslim-sortable").append(response.data.message);
            } else {
                alert(response.data.message);
            }
        })
        .fail(function() {
            alert(taslimAjax.error);
        })

    })


    $('form#form_fields_save').on('submit', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.post(taslimAjax.ajaxurl, data, function(response) {
            if (response.success) {
                console.log(response);
                $("#taslim_ajax_dispaly").html(response.data.message);
            } else {
                alert(response.data.message);
            }
        })
        .fail(function() {
            alert(taslimAjax.error);
        })
    });


  $( function() {
    $( "#taslim-sortable" ).sortable({
        cursor: 'move',
        'axis'                : 'y',
        placeholder: 'placeholder',
        start: function (e, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
        },
        update: function(event, ui){
            $("#taslim-sortable .taslim-field").each(function(i, el){
                   $(el).attr('row-id',$(el).index()+1);
            });
        }

    });
  //  $( "#taslim-sortable" ).disableSelection();
  });

    // $( '.taslimLabel' ).on( 'keyup', function() {
    //     var parentclass = $(this).parent();
    //     var taslimNewValue = $(this).val();
    //     taslimNewValue = taslimNewValue.replace(/\s+/g, '-').toLowerCase();
    //     parentclass.find(".taslimName").val(taslimNewValue);
    // });

    $( '#taslim-sortable' ).on( 'keyup', '.taslimLabel', function() {
        var parentclass = $(this).parent().parent();
        var taslimNewValue = $(this).val();
         parentclass.find(".taslim-left span.fieldlabeltext span").text(taslimNewValue);
    });


    $('form#form_fields_save').on('click', 'a.form-add-row', function(event) {
        event.preventDefault();
        console.log('hi');
        var tr = $(this).closest('tr');
        var clone = tr.clone(false, false);
        var order = $(this).closest('table').find('tbody > tr').length + 1;

        clone.find('input').each(function(index, el) {
           // this.name = el.name.replace(/\[(.+?)\]/g, "[" + order + "]");
        });

        clone.find('input[type="text"]').val('');
        clone.insertAfter( tr );
    });

    $('form#form_fields_save').on('click', 'a.remove-row', function(event) {
        event.preventDefault();

        var table = $(this).closest('table');

        if ( table.find('tbody tr').length > 1 ) {
            $(this).closest('tr').remove();
        }
    });

    $('form#form_fields_save').on('click', '.taslim-img-upload', function(e){
        e.preventDefault();
        console.log('click');
        var button = $(this),
        aw_uploader = wp.media({
            title: 'Custom image',
            library : {
                uploadedTo : wp.media.view.settings.post.id,
                type : 'image'
            },
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            console.log(attachment);
            $(button).find('.product_img').val(attachment.id);
            $(button).find('.product_imgurl').attr('src',attachment.url);
           // $(button).find('.product_img').val(attachment.url);
        })
        .open();
    });


})(jQuery)

//city list
jQuery(function($) {

    $('table.tdcitylist').on('click', 'a.add-row', function(event) {
        event.preventDefault();

        var tr = $(this).closest('tr');
        var clone = tr.clone(false, false);

        clone.find('input[type="text"]').val('');
        clone.find('input[type="checkbox"]').prop('checked', false);

        clone.insertAfter( tr );
    });

    $('table.tdcitylist').on('click', 'a.form-add-row', function(event) {
        event.preventDefault();

        var tr = $(this).closest('tr');
        var clone = tr.clone(false, false);
        var order = $(this).closest('table').find('tbody > tr').length + 1;

        clone.find('input, select, textarea').each(function(index, el) {
            this.name = el.name.replace(/\[(.+?)\]/g, "[" + order + "]");
        });

        clone.find('input[type="text"], textarea, select').val('');
        clone.insertAfter( tr );
    });

    $('table.tdcitylist').on('click', 'a.remove-row', function(event) {
        event.preventDefault();

        var table = $(this).closest('table');

        if ( table.find('tbody tr').length > 1 ) {
            $(this).closest('tr').remove();
        }
    });

});