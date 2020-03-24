<?php
/**
 * Custom Template für bildbasierte Downloads
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
<div class="download download-image">
    <a  href="<?php $dlm_download->the_download_link(); ?>"
        rel="nofollow"
        title="<?php _e( 'Datei herunterladen', 'congressomat' ); ?>">
        <?php $dlm_download->the_image(); ?>
    </a>
</div>