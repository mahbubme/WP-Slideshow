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
			uploaderTitle: window.wp_slideshow_admin.text_select_image, // The title of the media upload popup
			uploaderButton: window.wp_slideshow_admin.text_add_to_slider, // the text of the button in the media upload popup
			multiple: true, // Allow the user to select multiple images
		};

		const fileFrame = ( wp.media.frames.fileFrame = wp.media( {
			title: settings.uploaderTitle,
			button: {
				text: settings.uploaderButton,
			},
			multiple: settings.multiple,
		} ) );

		fileFrame
			.on( 'open', function () {
				const selection = fileFrame.state().get( 'selection' );
				const imageIds = getUploadedIds();

				// pre-select images which already selected
				imageIds.forEach( function ( imageId ) {
					const attachment = wp.media.attachment( imageId );
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				} );
			} )
			.open()
			.on( 'select', function () {
				const newAttachments = fileFrame.state().get( 'selection' );

				// render the selected attachments
				addToSLider( newAttachments );
			} );
	} );

	// When reorder images, update the list
	$( function () {
		$( '#sortable' ).sortable( {
			update() {
				displayMessage(
					window.wp_slideshow_admin.text_update_settings
				);
			},
		} );

		$( '#sortable' ).disableSelection();
	} );

	$( '#wp-slideshow-upload-image' ).on( 'click', function () {
		displayMessage( window.wp_slideshow_admin.text_update_settings );
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
		displayMessage( window.wp_slideshow_admin.text_update_settings );
	}

	function updateSliderSettings() {
		$.ajax( {
			url: window.wp_slideshow_admin.ajax_url,
			type: 'POST',
			data: {
				action: 'wp_slideshow_update_slider',
				nonce: window.wp_slideshow_admin.nonce,
				images: getUploadedIds(),
			},
			success() {
				displayMessage(
					window.wp_slideshow_admin.text_settings_updated,
					'success'
				);
			},
			error() {
				displayMessage(
					window.wp_slideshow_admin.text_settings_not_updated,
					'error'
				);
			},
		} );
	}

	function displayMessage( text, type = 'warning' ) {
		$( '#wp-slideshow-message' ).remove();
		$( '#wp-slideshow-submit' ).after( `
		<div id="wp-slideshow-message" class="notice notice-${ type } is-dismissible">
			<p>${ text }</p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text">${ window.wp_slideshow_admin.text_dismiss_notice }</span>
			</button> 
		</div>` );
	}
} );
