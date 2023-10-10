jQuery(function($) {

    // Event table
    $( '.event-table > .event-table__session > .event-table__session-toggle' ).click( function() {

        $( this ).toggleClass( 'open' );

        var details = $( this ).siblings( '.event-table__session-details' );
        details.toggleClass( 'open' );
        details.slideToggle( 'medium' );
    } );


    // Fix wpautop
    $( 'p:empty' ).remove();

} );
