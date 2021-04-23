jQuery( document ).ready( function ( $ ) {
	$( '#wp-slideshow-submit' ).on( 'click', function ( e ) {
		e.preventDefault();
		updateSliderSettings();
	} );

	$( '.wp-slideshow-remove-image' ).on( 'click', function ( e ) {
		removeSliderImage( e );
	} );

	// open media to upload slider images
	$( '#wp-slideshow-upload-image' ).click( function ( e ) {
		e.preventDefault();

		const settings = {
			uploaderTitle: wp_slideshow_admin.text_select_image, // The title of the media upload popup
			uploaderButton: wp_slideshow_admin.text_add_to_slider, // the text of the button in the media upload popup
			multiple: true, // Allow the user to select multiple images
		};

		const file_frame = ( wp.media.frames.file_frame = wp.media( {
			title: settings.uploaderTitle,
			button: {
				text: settings.uploaderButton,
			},
			multiple: settings.multiple,
		} ) );
		file_frame
			.on( 'open', function () {
				const selection = file_frame.state().get( 'selection' );
				image_ids = getUploadedIds();

				// pre-select images which already selected
				image_ids.forEach( function ( image_id ) {
					attachment = wp.media.attachment( image_id );
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				} );
			} )
			.open()
			.on( 'select', function () {
				const new_attachments = file_frame.state().get( 'selection' );

				// render the selected attachments
				addToSLider( new_attachments );
			} );
	} );

	// When reorder images, update the list
	$( function () {
		$( '#sortable' ).sortable( {
			update( e, u ) {
				window.WPSlideshowWarningMessage();
			},
		} );

		$( '#wp-slideshow-sortable-images' ).disableSelection();
	} );

	$( '#wp-slideshow-upload-image' ).on( 'click', function () {
		window.WPSlideshowWarningMessage();
	} );

	// return array of selected attachment ids
	function getUploadedIds() {
		const attachmentIds = [];
		$( '#sortable > li' ).each( function () {
			attachmentIds.push( $( this ).attr( 'data-id' ) );
		} );
		return attachmentIds;
	}

	// add images to slider
	function addToSLider( images ) {
		$( '#sortable' ).empty();

		images.forEach( function ( image ) {
			const img = $( '<img />' ).attr(
				'src',
				image.attributes.sizes.thumbnail.url
			);
			const item = `<li class="ui-state-default" data-id="${ image.id }">${ img[ 0 ].outerHTML }<div class="wp-slideshow-remove-image" data-id="${ image.id }"><span class="dashicons dashicons-no-alt"></span></div></li>`;
			$( '#sortable' ).append( item );
		} );

		$( '.wp-slideshow-remove-image' ).on( 'click', ( e ) => {
			removeSliderImage( e );
		} );
	}

	function removeSliderImage( event ) {
		$( event.target ).parents( 'li.ui-state-default ' ).remove();
		window.WPSlideshowWarningMessage();
	}

	function updateSliderSettings() {
		$.ajax( {
			url: wp_slideshow_admin.ajax_url,
			type: 'POST',
			data: {
				action: 'wp_slideshow_update_slider',
				nonce: wp_slideshow_admin.nonce,
				images: getUploadedIds(),
			},
			success() {
				window.WPSlideshowSuccessMessage();
			},
			error() {
				window.WPSlideshowErrorMessage();
			},
		} );
	}

	window.WPSlideshowWarningMessage = function () {
		$( '#success-message' ).remove();
		$( '#warning-message' ).remove();
		$( '#error-message' ).remove();
		$( '#wp-slideshow-submit' ).after(
			`
        <div id="warning-message" class="notice notice-warning is-dismissible">
            <p>` +
				wp_slideshow_admin.text_update_settings_warning +
				`</p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">` +
				wp_slideshow_admin.text_dismiss_notice +
				`</span>
            </button> 
        </div>`
		);
	};

	window.WPSlideshowSuccessMessage = function () {
		$( '#success-message' ).remove();
		$( '#warning-message' ).remove();
		$( '#error-message' ).remove();
		$( '#wp-slideshow-submit' ).after(
			`
        <div id="success-message" class="notice notice-success is-dismissible">
            <p>` +
				wp_slideshow_admin.text_settings_updated +
				`</p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">` +
				wp_slideshow_admin.text_dismiss_notice +
				`</span>
            </button>
        </div>`
		);
	};

	window.WPSlideshowErrorMessage = function () {
		$( '#success-message' ).remove();
		$( '#warning-message' ).remove();
		$( '#error-message' ).remove();
		$( '#wp-slideshow-submit' ).after(
			`
        <div id="error-message" class="error is-dismissible">
            <p>` +
				wp_slideshow_admin.text_settings_cannot_update +
				`</p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">` +
				wp_slideshow_admin.text_dismiss_notice +
				`</span>
            </button>
        </div>`
		);
	};
} );
