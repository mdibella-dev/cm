<?php
/**
 * Custom Template für einfache Download-Links mit Beschreibung
 *
 * @author Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 * @uses Plugin download-monitor
 */



/* Aussteigen, wenn direkt aufgerufen */

if( !defined( 'ABSPATH' ) ) :
    exit;
endif;

?>
<div class="download">
    <i class="fas fa-download"></i>
    <div>
        <a href="<?php $dlm_download->the_download_link(); ?>"
            rel="nofollow"
            title="<?php _e( 'Datei herunterladen', 'congressomat' ); ?>">
            <?php $dlm_download->the_title(); ?>
        </a>
        <?php $dlm_download->the_excerpt(); ?>
    </div>
</div>
