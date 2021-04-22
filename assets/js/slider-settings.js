// open media to upload slider images
jQuery( document ).ready(function( $ ) {
    $('#wp-slideshow-submit').on('click', (e) => {
        e.preventDefault();
        updateSliderSettings();
    });

    $('.wp-slideshow-remove-image').on('click', (e) => {
        removeSliderImage(e);
    });

    $( '#wp-slideshow-upload-image' ).click( function( e ) {
        e.preventDefault();

        var settings = {
            uploaderTitle: 'Select or upload image for slider', // The title of the media upload popup
            uploaderButton: 'Add To Slider', // the text of the button in the media upload popup
            multiple: true, // Allow the user to select multiple images
        };

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: settings.uploaderTitle,
            button: {
                text: settings.uploaderButton,
            },
            multiple: settings.multiple,
        });
        file_frame.on( 'open', function() {
            var selection = file_frame.state().get( 'selection' );
            image_ids = getUploadedIds();

            // pre-select images which already selected
            image_ids.forEach( function( image_id ) {
                attachment = wp.media.attachment( image_id );
                attachment.fetch();
                selection.add( attachment ? [ attachment ] : []);
            });
        })
        .open()
        .on('select', function () {
            var new_attachments = file_frame.state().get('selection');

            // render the selected attachments
            addToSLider( new_attachments );
        });
    });

    // return array of selected attachment ids
    function getUploadedIds() {
        var attachmentIds = [];
        $( '#sortable > li' ).each( function() {
            attachmentIds.push( $( this ).attr( 'data-id' ) );
        });
        return attachmentIds;
    }

    // add images to slider
    function addToSLider( images ) {
        $( '#sortable' ).empty();

        images.forEach( function( image ) {
            var img = $( '<img />' ).attr( 'src', image.attributes.sizes.thumbnail.url );
            var item = `<li class="ui-state-default" data-id="${image.id}">${img[0].outerHTML}<div class="wp-slideshow-remove-image" data-id="${image.id}"><span class="dashicons dashicons-no-alt"></span></div></li>`;
            $( '#sortable' ).append( item );
        });

        $('.wp-slideshow-remove-image').on('click', (e) => {
            removeSliderImage(e);
        });
    }

    function removeSliderImage( event ) {
        $(event.target).parents('li.ui-state-default ').remove();
        window.WPSlideshowWarningMessage();
    }

    function updateSliderSettings() {
        $.ajax({
            url: wp_slideshow_admin.ajax_url,
            type: 'POST',
            data: {
                action: 'wp_slideshow_update_slider',
                nonce: wp_slideshow_admin.nonce,
                images: getUploadedIds()
            },
            success: function() {
                window.WPSlideshowSuccessMessage();
            },
            error: function() {
                window.WPSlideshowErrorMessage();
            }
        })
    }
});
