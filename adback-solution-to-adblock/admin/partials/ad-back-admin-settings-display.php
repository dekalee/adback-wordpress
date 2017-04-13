<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/admin/partials
 */

?>
<h1 class="ab-h1"><?php _e( 'AdBack Settings', 'adback-solution-to-adblock' ); ?></h1>
<div id="ab-settings">
    <h3><?php _e('Display message', 'adback-solution-to-adblock'); ?></h3>
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php esc_html_e('Activate your message', 'adback-solution-to-adblock'); ?></span>
        </legend>
        <label for="ab-settings-display">
            <input type="checkbox" id="ab-settings-display" value="1" <?php echo ($messages['display'] == '1' ? "checked='checked'" : ""); ?>> <?php esc_html_e('Activate your message', 'adback-solution-to-adblock'); ?>
        </label>
    </fieldset>
<br/>
    <fieldset>
        <legend class="screen-reader-text">
            <span><?php esc_html_e('No message for logged in Wordpress admin', 'adback-solution-to-adblock'); ?></span>
        </legend>
        <label for="ab-settings-hide-admin">
            <input type="checkbox" id="ab-settings-hide-admin" value="0" <?php echo (get_option('adback_admin_hide_message', '1') === '1' ? "checked='checked'" : ""); ?>> <?php esc_html_e('No message for logged in Wordpress admin', 'adback-solution-to-adblock'); ?>
        </label>
    </fieldset>
	<p class="submit">
		<input type="submit" id="ab-settings-submit" class="button button-primary" value="<?php esc_html_e('Save', 'adback-solution-to-adblock'); ?>">
	</p>
</div>
<div class="ab-primary-setting">
    <h3><?php esc_html_e('Adback Account', 'adback-solution-to-adblock'); ?></h3>
    <button id="ab-logout" class="button button-primary"><?php esc_html_e('Log out', 'adback-solution-to-adblock'); ?></button>
</div>
