<?php
/**
 * Template für den Fußbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/
?>
<footer id="footer">
<section id="footer-widgets" class="adjust-workspace">
<div class="widget-area-wrapper">
<?php
// Widget-Areas generieren
$areas = array( 'footer-one', 'footer-two', 'footer-three' );

foreach( $areas as $area ) :
    echo '<div class="widget-area">';
    dynamic_sidebar( $area );
    echo '</div>';
endforeach;
?>
</div>
</section>
</footer>
<?php wp_footer(); ?>
</body>
</html>
