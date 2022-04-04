<?php
/**
 * Custom Template für bildbasierte Downloads
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package cm
 * @uses    Plugin download-monitor
 */


defined( 'ABSPATH' ) or exit;


?>
<div class="download download-image">
    <a  href="<?php $dlm_download->the_download_link(); ?>"
        rel="nofollow"
        title="<?php echo __( 'Datei herunterladen', 'cm' ); ?>">
        <?php $dlm_download->the_image(); ?>
    </a>
</div>
