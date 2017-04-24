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

$subscription = $this->askSubscription();

$showTrial = is_array($subscription) && ($subscription['trial'] || $subscription['trial_status'] == 1 || $subscription['allowed'] > 0);

$progress = $subscription['progress'];
$allowed = $subscription['trial_status'] == 1 ? 10000 : $subscription['allowed'];

?>
<h1><?php _e( 'AdBack Message', 'adback-solution-to-adblock' ); ?></h1>

<div id="ab-go-settings">
    <div class="ab-login-box ab-discover <?php if ($showTrial) { echo 'ab-with-trial'; } ?>">
        <h2><?php esc_html_e('Activate and customize your message!', 'adback-solution-to-adblock'); ?></h2>
        <h3>1. <?php esc_html_e('Activate your message', 'adback-solution-to-adblock'); ?></h3>
        <fieldset>
            <legend class="screen-reader-text">
                <span><?php esc_html_e('Activate your message', 'adback-solution-to-adblock'); ?></span>
            </legend>
            <label for="ab-go-settings-display">
                <input type="checkbox" id="ab-go-settings-display" value="1" <?php echo ($messages['display'] == '1' ? "checked='checked'" : ""); ?>> <?php esc_html_e('Activate your message', 'adback-solution-to-adblock'); ?>
                <input type="submit" id="ab-go-settings-submit" class="button button-primary" value="<?php esc_html_e('Save', 'adback-solution-to-adblock'); ?>">
            </label>
        </fieldset>
        <h3>2. <?php esc_html_e('Customize your message', 'adback-solution-to-adblock'); ?></h3>
        <p>
            <?php _e('Customize message description', 'adback-solution-to-adblock'); ?>
        </p>
        <span><a href="https://www.adback.co/en/monitoring/custom" target="_blank" class="button button-ab"><?php _e('Customize my message on AdBack.co', 'adback-solution-to-adblock'); ?></a></span>
        <span><a href="https://www.adback.co/en/monitoring/custom" target="_blank"><img style="max-width: 710px;width: 100%;" src="<?php echo plugin_dir_url( __FILE__ ); ?>images/custom_message.png"/></a></span>
    </div>
    <?php if ($showTrial) { ?>
    <div class="ab-trial-box">
        <h2><?php echo $progress."/".$allowed." messages"; ?></h2>
        <div class="ab-progress">
            <div class="ab-progress-bar" role="progressbar" style="width:<?php echo $allowed > 0 ? ceil($progress / $allowed * 100) : 100 ?>%">
            </div>
        </div>
        <?php if ($subscription['trial_status'] == 1) { ?>
            <p>
                <?php _e('Free trial description', 'adback-solution-to-adblock'); ?>
            </p>
            <a href="https://www.adback.co" target="_blank" class="button button-ab"><?php _e('Free trial start', 'adback-solution-to-adblock'); ?></a>
        <?php } ?>
    </div>
    <?php } ?>
</div>
