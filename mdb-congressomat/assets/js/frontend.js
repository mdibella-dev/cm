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
            //$body.removeClass( 'dimmed' );
            current = -1;
        }
        else {
            $item.addClass( 'open' );
            //$body.addClass( 'dimmed' );
            current = idx;
            $body.off( 'click' ).on( 'click', close );
        }
        return false;
    }

    function close( event ) {
        $listItems.eq( current ).removeClass( 'open' );
        //$body.removeClass( 'dimmed' );
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
