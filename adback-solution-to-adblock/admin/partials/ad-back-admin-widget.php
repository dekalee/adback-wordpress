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
<h2><?php _e('Yesterday', 'adback-solution-to-adblock'); ?></h2>
<br/>
<table id="table-page-view" data-ab-table data-ab-type="yesterday-table-page-views" style="display: none;">
    <thead>
    <tr>
        <th class="name"></th>
        <th class="number"><?php _e( 'Number', 'adback-solution-to-adblock'); ?></th>
        <th class="rate">%</th>
    </tr>
    </thead>
    <tbody>
    <tr class="sample">
        <td class="name"></td>
        <td class="number"></td>
        <td class="rate"></td>
    </tr>
    </tbody>
</table>
<hr/>
<br/>
<h2><?php _e('Last 7 days', 'adback-solution-to-adblock'); ?></h2>
<br/>
<h3><?php _e( 'Adblock removals', 'adback-solution-to-adblock' ); ?></h3>
<p><?php _e( '% adblock removals after showing message', 'adback-solution-to-adblock' ); ?></p>
<div data-ab-graph data-ab-type="last-7-adblocker-rate" data-ab-no-period="1" data-ab-no-data="<?php printf(esc_attr('No custom message enabled. You can enable it <a href="%s">here</a>', 'adback-solution-to-adblock'), get_admin_url(null, 'admin.php?page=ab-settings') ); ?>" style="width: 95%; height: 200px; margin-bottom: 10px;">
</div>
<hr/>
<h3><?php _e( 'Blocked page view and percent', 'adback-solution-to-adblock' ); ?></h3>
<div data-ab-graph data-ab-type="last-7-page-view-adblocker-percent" data-ab-no-period="1" style="width: 95%; height: 400px; margin-bottom: 50px;">
</div>

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
<style>
    #table-page-view {
        border-collapse: collapse;
    }
    #table-page-view .sample {
        display:none;
    }
    #table-page-view td {
        border:1px solid #e5e5e5;
        margin: 0;
    }
    #table-page-view td, #table-page-view th{
        padding: 10px;
    }
    #table-page-view thead{
        background-color: #f1f1f1;
    }
    #table-page-view th.number, #table-page-view th.rate{
        border-left: 1px solid #e5e5e5;
        border-right: 1px solid #e5e5e5;
    }
    #table-page-view .rate{
        min-width: 50px;
    }
</style>
