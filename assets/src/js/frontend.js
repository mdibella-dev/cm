jQuery(function($) {

    // FAQ panels
    $( '.faq-accordion > ul > .faq-element > .faq-question' ).click(function() {
        $( this ).toggleClass( 'on' );
        $( this ).next().slideToggle( 'medium' );
    } );


    // Akkordion
    $( '.accordion > ul > .accordion-element > .accordion-caption' ).click(function() {
        $( this ).toggleClass( 'open' );
        $( this ).next().slideToggle( 'medium' );
    } );


    // Event-Table
    $( '.event-table > .event-table__session > .event-table__session-toggle' ).click(function() {

        $( this ).toggleClass( 'open' );

        var details = $( this ).siblings( '.event-table__session-details' );
        details.toggleClass( 'open' );
        details.slideToggle( 'medium' );
    } );


    // Korrektur von wpautop
    $( 'p:empty' ).remove();

} );