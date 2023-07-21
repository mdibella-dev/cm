<?php
/**
 * Custom template for image-based downloads.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 * @uses    Plugin download-monitor
 */


/** Prevent direct access */

defined( 'ABSPATH' ) or exit;


?>
<div class="download download-image">
    <a  href="<?php $dlm_download->the_download_link(); ?>"
        rel="nofollow"
        title="<?php echo __( 'Datei herunterladen', 'cm' ); ?>">
        <?php $dlm_download->the_image(); ?>
    </a>
</div>
