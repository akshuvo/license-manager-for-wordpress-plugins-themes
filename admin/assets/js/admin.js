(function($) {
	"use strict";
	$(document).ready(function(){

        var file_frame;

        // Add File
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


	});
})(jQuery);

