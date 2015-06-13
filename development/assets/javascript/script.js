(function($) {

    /**
     * Select or deselect group of checkboxes regarding a main checkbox state
     */
    $( '.wellcrafted_checkboxes_group_toggler' ).change(function() {
        var target = $( this ).data( 'target' ),
            state = $( this ).is(':checked' );

        $( target ).prop( 'checked', state)
    } );

    /**
     *  Modify Publish meta box
     */
    if ( 'wc_support_request' == window.wellcrafted_post_type.current_post_type ) {
        $( '#minor-publishing-actions, .misc-pub-section' ).hide();
        $( '#submitdiv .hndle span' ).text( window.wellcrafted_support['save-n-send'] );
        $( '#publish' ).val( window.wellcrafted_support.save );
    }

    /**
     * Ask user before sending
     */
    $( '#wellcrafted-support-send' ).click( function() {
        if ( ! confirm( 'Are you sure you want to send a support request?' ) ) {
            return false;
        }
    } );

})(jQuery)