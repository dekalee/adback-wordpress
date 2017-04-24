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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1 class="ab-lefty"><?php _e( 'AdBack : The stats of your AdBlock audience', 'adback-solution-to-adblock' ); ?></h1>
<div class="ab-share">
    <div class="ab-share-actions">
        <a target="_blank"
           href="https://twitter.com/intent/tweet?text=<?php echo urlencode("Re-establish dialogue and monetize your adblocked audience with this stunning WordPress plugin"); ?>&url=http://bit.ly/2oLYrHs&via=adback_co"
           class="ab-tweet"><span></span><?php _e( 'Tweet about it', 'adback-solution-to-adblock' ); ?>
        </a>
        <a target="_blank" href="https://wordpress.org/support/plugin/adback-solution-to-adblock/reviews/"
           class="ab-review"><span></span><?php _e( 'Leave a review', 'adback-solution-to-adblock' ); ?>
        </a>
    </div>
    <div class="clear"></div>
</div>
<p>
    <?php _e('Statistics description', 'adback-solution-to-adblock'); ?>
</p>
<hr class="clear">

<h2><?php _e( 'Blocked page view and percent', 'adback-solution-to-adblock' ); ?></h2>
<h4><?php _e( 'Blocked page view and percent - Sub', 'adback-solution-to-adblock' ); ?></h4>
<div data-ab-graph data-ab-type="page-view-adblocker-percent" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>


<h2><?php _e( 'New - former adblock users', 'adback-solution-to-adblock' ); ?></h2>
<h4><?php _e( 'New - former adblock users - Sub', 'adback-solution-to-adblock' ); ?></h4>
<div data-ab-graph data-ab-type="adblocker-new-old" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>

<h2><?php _e( 'Bounce rate of adblocker users', 'adback-solution-to-adblock' ); ?></h2>
<div data-ab-graph data-ab-type="bounce" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>

<h2><?php _e( 'Browser', 'adback-solution-to-adblock' ); ?></h2>
<div data-ab-graph data-ab-type="browser" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>
<hr>

<center>
	<a href="<?php _e('https://www.adback.co/en/sites/dashboard', 'adback-solution-to-adblock'); ?>" target="_blank" class="button button-primary button-ab"><?php esc_html_e('Discover', 'adback-solution-to-adblock'); ?></a>
</center>

<script type="text/javascript">
	window.onload = function() {
		if(typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo $this->getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>'
            });
        }
    }
</script>
