<?php
/**
 * Template für den Fußbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/
?>
<footer id="footer">
<?php
// Ausgabe puffern
ob_start();

// Widget-Areas generieren
$areas = array( 'footer-one', 'footer-two', 'footer-three' );

foreach( $areas as $area ) :
    echo '<div class="widget-area">';
    dynamic_sidebar( 'footer-one' );
    echo '</div>';
endforeach;

// Ausgabenpuffer sichern; Pufferung beenden
$buffer = ob_get_contents();
ob_end_clean();

// Modul generieren
echo mdb_do_module( array( 'classes' => array( 'module-footer-widgets') ), $buffer );
?>
</footer>
<?php wp_footer(); ?>
</body>
</html>
