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


    // Live-Panels
    $( '.live-panel-list > ul > .live-panel > .live-panel-caption' ).click(function() {

        var this_panel = $( this ).parent();

        if( ! this_panel.hasClass( 'open' ) ) {

            var open_panel = $( this ).parents( '.live-panel-list > ul' ).find('.open');

            open_panel.removeClass( 'open' );
            this_panel.addClass( 'open' );
            this_panel.children( '.live-panel-content' ).slideToggle( 'medium' );
            open_panel.children( '.live-panel-content' ).slideToggle( 'medium' );
        } else {
            this_panel.removeClass( 'open' );
            this_panel.children( '.live-panel-content' ).slideToggle( 'medium' );
        }

        e.stopPropagation();
    } );


    // Korrektur von wpautop
    $( 'p:empty' ).remove();

} );
