<?php
/**
 * Custom Template für einfache Download-Links
 *
 * @since   1.0.0
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 * @uses    Plugin download-monitor
 */



/* Aussteigen, wenn direkt aufgerufen */

if( !defined( 'ABSPATH' ) ) :
    exit;
endif;


?>
<div class="download download-link">
    <i class="fas fa-download"></i>
    <div>
        <a href="<?php $dlm_download->the_download_link(); ?>"
            rel="nofollow"
            title="<?php _e( 'Datei herunterladen', 'congressomat' ); ?>">
            <?php $dlm_download->the_title(); ?>
        </a>
    </div>
</div>
