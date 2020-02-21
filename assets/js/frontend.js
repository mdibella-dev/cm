jQuery(function($) {

// Megamenu
var cbpHorizontalMenu = (function() {

    var $listItems = $( '.site-menu > ul > li' ),
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
            if( $item.hasClass( 'submenu' ) ) {
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
$( '.site-menu-toggle' ).click( function() {
    $( this ).toggleClass( 'toggle-on' );
    $( '.site-menu' ).toggleClass( 'toggle-on' );
} );


// FAQ panels
$( '.faq-accordion > ul > .faq-element > .faq-question' ).click(function() {
    $( this ).toggleClass( 'on' );
    $( this ).next().slideToggle( 'medium' );
} );


// Korrektur von wpautop
$( 'p:empty' ).remove();

} );
