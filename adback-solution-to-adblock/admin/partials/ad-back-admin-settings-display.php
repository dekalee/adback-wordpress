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
<?php include "ad-back-admin-header.php" ?>
<h1 class="ab-h1"><?php _e( 'AdBack Settings', 'ad-back' ); ?></h1>
<div id="ab-settings">
    <div id="ab-full-app">
        <div id="ab-configuration-form"></div>
        <div class="ab-primary-setting">
            <h3><?php esc_html_e('Adback Account', 'ad-back'); ?></h3>
            <button id="ab-logout" primary m-full><?php esc_html_e('Log out', 'ad-back'); ?></button>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function () {
        if (typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>',
                version: 1
            });
        }
    }
</script>
