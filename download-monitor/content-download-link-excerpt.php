<?php
/**
 * Custom template for simple download links with description.
 *
 * @author  Marco Di Bella
 * @package cm-theme
 * @uses    Plugin download-monitor
 */


/** Prevent direct access */

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
        <p class="description">
            <?php echo strip_tags( get_the_excerpt( $dlm_download->get_id() ) ); ?>
        </p>
    </div>
</div>
