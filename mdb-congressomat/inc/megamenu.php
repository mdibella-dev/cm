<?php
/**
 * MegaMenu
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



/**
 * Fügt eine Metabox für die MegaMenu-Items hinzu
 *
 * @param  object   $object   The meta box object
 * @source https://developer.wordpress.org/reference/functions/add_meta_box/
 **/

function mdb_add_megamenu_metabox( $object )
{
	add_meta_box( 'megamenu-metabox', __( 'MegaMenu', TEXT_DOMAIN ), 'mdb_megamenu_metabox', 'nav-menus', 'side', 'default' );

	return $object;
}




/**
 * Zeigt die Metabox für die MegaMenu-Items an
 *
 * @source https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/nav-menu.php
 * @source https://core.trac.wordpress.org/browser/tags/4.5/src/wp-admin/includes/class-walker-nav-menu-edit.php
 **/
function mdb_megamenu_metabox()
{
	global $_nav_menu_placeholder, $nav_menu_selected_id;

    $_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
?>
<div id="megamenudiv" class="customlinkdiv">
<input type="hidden" value="custom" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" />

<p id="menu-item-url-wrap" class="wp-clearfix">
<label class="howto" for="custom-menu-item-url"><?php _e( 'URL' ); ?></label>
<input id="custom-menu-item-url" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-url]" type="text" class="code menu-item-textbox" value="http://" />
</p>

<p id="menu-item-name-wrap" class="wp-clearfix">
<label class="howto" for="custom-menu-item-name"><?php _e( 'Link Text' ); ?></label>
<input id="custom-menu-item-name" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" type="text" class="regular-text menu-item-textbox" />
</p>

<p class="button-controls wp-clearfix">
<span class="add-to-menu">
<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-custom-menu-item" id="submit-customlinkdiv" />
<span class="spinner"></span>
</span>
</p>

</div><!-- /.customlinkdiv -->
<?php
}
