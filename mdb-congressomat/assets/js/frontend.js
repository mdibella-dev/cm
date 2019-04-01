jQuery(function($) {

// Megamenu
var cbpHorizontalMenu = (function() {

    var $listItems = $( '#primary > ul > li' ),
        $menuItems = $listItems.children( 'a' ),
        $body   = $( 'body' ),
        current = -1;

    function init() {
        $menuItems.on( 'click', open );
        $listItems.on( 'click', function( event ) { event.stopPropagation(); } );
    }

    function open( event ) {

        if( current !== -1 ) {
            $listItems.eq( current ).removeClass( 'open' );
        }

        var $item = $( event.currentTarget ).parent( 'li' ),
            idx = $item.index();

        if( current === idx ) {
            $item.removeClass( 'open' );
            current = -1;
        }
        else {
            if( $item.hasClass( 'megamenu' ) ) {
                $item.addClass( 'open' );
                current = idx;
                $body.off( 'click' ).on( 'click', close );
            } else {
                window.location.href = $( event.currentTarget ).attr( 'href' );
            }
        }
        return false;
    }

    function close( event ) {
        $listItems.eq( current ).removeClass( 'open' );
        current = -1;
    }

    return { init : init };

})();

cbpHorizontalMenu.init();


// Toggle button
$( '#toggle' ).click( function() {
    $( this ).toggleClass( 'on' );
    $( '#primary' ).toggleClass( 'on' );
} );


// FAQ panels
$( '.faq-accordion > li > h3' ).click(function() {
    $( this ).toggleClass( 'on' );
    $( this ).next().slideToggle( 'medium' );
} );


} );
