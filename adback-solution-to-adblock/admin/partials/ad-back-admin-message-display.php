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
<?php include "ad-back-admin-header.php" ?>
<h1><?php _e( 'AdBack Message', 'ad-back' ); ?></h1>

<div id="ab-full-app" style="overflow: hidden;">
    <grid>
        <div col="3/4">
            <div id="ab-full-form"></div>
        </div>
        <div col="1/4">
            <div id="adb-stats">
                <progress-bar type="subscription"
                              dashboardlink="<?php _e('https://www.adback.co/en/sites/dashboard', 'ad-back'); ?>"
                              pricelink="<?php _e('https://www.adback.co/en/#prix', 'ad-back'); ?>"
                              reviewlink="<?php _e('https://wordpress.org/support/plugin/adback-solution-to-adblock/reviews/', 'ad-back') ?>"
                >

                </progress-bar>
            </div>
        </div>
    </grid>

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
