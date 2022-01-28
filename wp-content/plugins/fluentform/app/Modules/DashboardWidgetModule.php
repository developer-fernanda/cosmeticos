<?php

namespace FluentForm\App\Modules;

class DashboardWidgetModule
{
    public function showStat()
    {
        global $wpdb;
        $stats = wpFluent()->table('fluentform_submissions')
            ->select([
                'fluentform_forms.title',
                'fluentform_submissions.form_id',
                wpFluent()->raw('count(' . $wpdb->prefix . 'fluentform_submissions.id) as total'),
                wpFluent()->raw('max(' . $wpdb->prefix . 'fluentform_submissions.id) as max_id'),
            ])
            ->orderBy('max_id', 'DESC')
            ->groupBy('fluentform_submissions.form_id')
            ->join('fluentform_forms', 'fluentform_forms.id', '=', 'fluentform_submissions.form_id')
            ->limit(10)
            ->get();

        if (!$stats) {
            echo 'You can see your submission stats here';
            return;
        }

        foreach ($stats as $stat) {
            $stat->unreadCount = $this->getUnreadCount($stat->form_id);
        }

        $this->printStats($stats);
        return;
    }

    private function printStats($stats)
    {
        ?>
        <ul class="ff_dashboard_stats">
            <?php foreach ($stats as $stat): ?>
                <li>
                    <a href="<?php echo admin_url('admin.php?page=fluent_forms&route=entries&form_id=' . $stat->form_id); ?>">
                        <?php echo $stat->title; ?>
                        <span class="ff_total"><?php echo $stat->unreadCount; ?>/<?php echo $stat->total; ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ( !defined('ENHANCED_BLOCKS_VERSION') && !defined('FLUENTFORMPRO') ) : ?>
            <div class="ff_recommended_plugin">
                Recommended Plugin: <b>Enhanced Blocks – Page Builder Blocks for Gutenberg</b> <br />
                <a href="<?php echo $this->getInstallUrl('enhanced-blocks'); ?>">Install</a>
                | <a target="_blank" rel="noopener" href="https://wordpress.org/plugins/enhanced-blocks/">Learn More</a>
            </div>
        <?php endif; ?>
        <style>
            ul.ff_dashboard_stats {
                margin: 0;
                padding: 0;
                list-style: none;
            }

            ul.ff_dashboard_stats li {
                padding: 8px 12px;
                border-bottom: 1px solid #eeeeee;
                margin: 0 -12px;
                cursor: pointer;
            }

            ul.ff_dashboard_stats li:hover {
                background: #fafafa;
                border-bottom: 1px solid #eeeeee;
            }

            ul.ff_dashboard_stats li:hover a {
                color: black;
            }

            ul.ff_dashboard_stats li:nth-child(2n+2) {
                background: #f9f9f9;
            }

            ul.ff_dashboard_stats li span.ff_total {
                float: right;
            }

            ul.ff_dashboard_stats li a {
                display: block;
                color: #0073aa;
                font-weight: 500;
                font-size: 105%;
            }

            .ff_recommended_plugin {
                padding: 15px 0px 0px;
            }
            .ff_recommended_plugin a {
                font-weight: bold;
                font-size: 110%;
            }
        </style>
        <?php
    }

    private function getInstallUrl($plugin)
    {
        return wp_nonce_url(
            self_admin_url('update.php?action=install-plugin&plugin=' . $plugin),
            'install-plugin_' . $plugin
        );
    }

    private function getUnreadCount($formId)
    {
        return wpFluent()->table('fluentform_submissions')
            ->where('status', 'unread')
            ->where('form_id', $formId)
            ->count();
    }
}
