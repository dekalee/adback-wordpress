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
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1><?php _e('AdBack : The stats of your AdBlock audience', 'ad-back'); ?></h1>

<p>
    <?php _e('Statistics description', 'ad-back'); ?>
</p>
<hr class="clear">

<div class="tabs">
    <a href="#global-stats">Global Statistique</a>
    <a href="#money-stats">Monetisation Statistique</a>
</div>


<div id="global-stats" class="tab">
<div id="ab-full-app">
    <div id="vue-app">
        <grid>
        <div col="3/4">
            <datepicker></datepicker>

            <div class="block-white">
                <h4><?php _e('Blocked page view and percent', 'ad-back'); ?></h4>
                <h7><?php _e('Blocked page view and percent - Sub', 'ad-back'); ?></h7>
                <graph type="page-view-adblocker-percent"
                       style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                </graph>
            </div>

            <div class="block-white">
                <h4><?php _e('New - former adblock users', 'ad-back'); ?></h4>
                <h7><?php _e('New - former adblock users - Sub', 'ad-back'); ?></h7>
                <graph type="adblocker-new-old"
                       style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                </graph>
            </div>

            <div class="block-white">
                <h4><?php _e('Bounce rate of adblocker users', 'ad-back'); ?></h4>
                <graph type="bounce"
                       style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                </graph>
            </div>

            <div class="block-white">
                <h4><?php _e('Browser', 'ad-back'); ?></h4>
                <graph type="browser"
                       style="width: 95%; height: 400px; margin-bottom: 50px; position:relative;">
                </graph>
            </div>
        </div>

        <div col="1/4">
            <div>
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
</div>
<center>
    <a href="<?php _e('https://www.adback.co/en/sites/dashboard', 'ad-back'); ?>" target="_blank"
       class="button button-primary button-ab"><?php esc_html_e('Discover', 'ad-back'); ?></a>
</center>
</div>
<div id="money-stats" class="tab" style="display:none;">

</div>
<script type="text/javascript">
    window.onload = function () {
        if (typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>'
            });
        } else {
            (function ($) {
                $("div[data-ab-graph]").each(function () {
                    $(this).append('<?php esc_js(printf(__('No data available, please <a href="%s">refresh domain</a>', 'ad-back'),
                        esc_url(home_url('/wp-admin/admin.php?page=ab-refresh-domain')))); ?>');
                });
            })(jQuery);
        }

        (function($) {
            $('.tabs a').click(function () {
                console.log($($(this).attr('href')));
                if ($($(this).attr('href')).is(':visible')) {
                    return false;
                }
                $('.tab').hide();
                $($(this).attr('href')).show();
                return false;
            });

        })(jQuery);
    }
</script>
