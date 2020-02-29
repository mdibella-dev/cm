jQuery(function($) {

// FAQ panels
$( '.faq-accordion > ul > .faq-element > .faq-question' ).click(function() {
    $( this ).toggleClass( 'on' );
    $( this ).next().slideToggle( 'medium' );
} );


// Korrektur von wpautop
$( 'p:empty' ).remove();

} );
