
/*jshint esversion: 6 */


jQuery( document ).ready(function( $ ) {

    // Whenever the user reorders images, update the slideshow with it
    $( function() {
        $( '#sortable' ).sortable({
            update: function( e, u ) {
                displayWarningMessage();
            }
        });
        $( '#wp-slideshow-sortable-images' ).disableSelection();
    });

    function displayWarningMessage() {
        $( '#success-message' ).remove();
        $( '#warning-message' ).remove();
        $( '#wp-slideshow-submit' ).after( `
        <div id="warning-message" class="notice notice-warning is-dismissible">
            <p>Please click on the 'Save Changes' button to save the changes.</p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">Dismiss this notice.</span>
            </button> 
        </div>` );
    }

});
