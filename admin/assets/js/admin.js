(function($) {
	"use strict";
	$(document).ready(function(){

		// Add License Field
        $(document).on('click', '.add-license-information', function(){
            var $this = $(this);

            var keyLen = jQuery('.lmfwppt_license_field').length;

            var data = {
                action: 'lmfwppt_single_license_field',
                key: keyLen,
                thiskey: keyLen,
            }

            $.ajax({
              url: ajaxurl,
              type: 'post',
              data: data,
              beforeSend : function ( xhr ) {
                $this.prop('disabled', true);
              },
              success: function( res ) {
                $this.prop('disabled', false);

                // Data push
                $('#license-information-fields').append(res);
              },
              error: function( result ) {
                $this.prop('disabled', false);
                console.error( result );
              }
            });
        });

        // Delete field
        $(document).on('click', 'span.delete_field', function(e){
            e.preventDefault();
            $(this).closest('.lmfwppt_license_field').remove();
            return false;
        });

        // Field toggle
        $(document).on('click', '.lmfwppt-toggle-head', function(e){
        	e.preventDefault();
            $(this).parent().toggleClass('opened').find('.lmfwppt-toggle-wrap').slideToggle('fast');
            return false;
        });

        // Add File
        var file_frame;
        $(document).on('click', '#download_link_button', function(){
            var $this = $(this);

            if ( undefined !== file_frame ) {
                file_frame.open();
                return;
            }

            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select Theme/Plugin File',
                //frame:    'post',
                //state:    'insert',
                multiple: false,
                library: {
                    //type: [ 'zip' ]
                },
                button: {text: 'Insert'}
            });

            file_frame.on( 'select', function() {

                var attachment = file_frame.state().get('selection').first().toJSON();
                $('#download_link').val( attachment.url );

            });

            // Now display the actual file_frame
            file_frame.open();

        });

        // Add Product
        $(document).on('submit', '#product-form', function(e) {
            e.preventDefault();
            var $this = $(this);

            var formData = new FormData(this);
            formData.append('action', 'product_add_form');

            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(data) {


                },
                complete: function(data) {

                },
                success: function(data) {


                    //var response = JSON.parse(data);


                    console.log(data);

                },
                error: function(data) {
                    console.log(data);

                },

            });

        });


	});
})(jQuery);

