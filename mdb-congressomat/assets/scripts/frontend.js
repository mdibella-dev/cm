jQuery(function($) {
    /**
     * MegaMenu
     ***/

/*    //duplicate hover state for parent menu when dropdown.
    $( '#header-wrapper ul.dropdown' ).hover(
        function() {
    		$(this).parent().find('> a').addClass('expanded-menu');
    	},
        function(){
    		$(this).parent().find('> a').removeClass('expanded-menu');
    	});
*/

    $( '.menu-item-mega' ).hover( function() {
        //$(this).children( '.sub-menu' ).classList.toggle( 'open' );
        //$(this).parent().toggleClass('open' );
        $(this).toggleClass( 'open' );
    } );

} );
