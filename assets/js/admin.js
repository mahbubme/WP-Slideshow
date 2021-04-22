jQuery( document ).ready(function( $ ) {

    // When reorder images, update the list
    $( function() {
        $( '#sortable' ).sortable({
            update: function( e, u ) {
                window.WPSlideshowWarningMessage();
            }
        });
        $( '#wp-slideshow-sortable-images' ).disableSelection();
    });

    $('#wp-slideshow-upload-image').on('click', function(){
        window.WPSlideshowWarningMessage();
    });

    window.WPSlideshowWarningMessage  = function() {
        $( '#success-message' ).remove();
        $( '#warning-message' ).remove();
        $( '#error-message' ).remove();
        $( '#wp-slideshow-submit' ).after( `
        <div id="warning-message" class="notice notice-warning is-dismissible">
            <p>Please click on the button to update the settings.</p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">Dismiss this notice.</span>
            </button> 
        </div>` );
    }

    window.WPSlideshowSuccessMessage = function() {
        $( '#success-message' ).remove();
        $( '#warning-message' ).remove();
        $( '#error-message' ).remove();
        $( '#wp-slideshow-submit' ).after( `
        <div id="success-message" class="notice notice-success is-dismissible">
            <p>Settings Updated</p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">Dismiss this notice.</span>
            </button>
        </div>` );
    }

    window.WPSlideshowErrorMessage = function() {
        $( '#success-message' ).remove();
        $( '#warning-message' ).remove();
        $( '#error-message' ).remove();
        $( '#wp-slideshow-submit' ).after( `
        <div id="error-message" class="error is-dismissible">
            <p><strong>Error</strong>: Settings Cannot be Updated</p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">Dismiss this notice.</span>
            </button>
        </div>` );
    }

});
