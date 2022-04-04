<?php
/**
 * Custom Template für einfache Download-Links mit Beschreibung
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 * @uses    Plugin download-monitor
 */


defined( 'ABSPATH' ) or exit;


?>
<div class="download download-link">
    <i class="fas fa-download"></i>
    <div>
        <a href="<?php $dlm_download->the_download_link(); ?>"
            rel="nofollow"
            title="<?php echo __( 'Datei herunterladen', 'congressomat' ); ?>">
            <?php $dlm_download->the_title(); ?>
        </a>
        <p class="description">
            <?php echo strip_tags( get_the_excerpt( $dlm_download->get_id() ) ); ?>
        </p>
    </div>
</div>
