<?php
/**
 * Custom Template für einfache Download-Links
 *
 * @author  Marco Di Bella 
 * @package cm
 * @uses    Plugin download-monitor
 */


defined( 'ABSPATH' ) or exit;


?>
<div class="download download-link">
    <i class="fas fa-download"></i>
    <div>
        <a  href="<?php $dlm_download->the_download_link(); ?>"
            rel="nofollow"
            title="<?php echo __( 'Datei herunterladen', 'cm' ); ?>">
            <?php $dlm_download->the_title(); ?>
        </a>
    </div>
</div>
