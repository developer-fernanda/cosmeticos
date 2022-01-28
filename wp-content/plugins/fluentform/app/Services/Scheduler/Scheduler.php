<?php

namespace FluentForm\App\Services\Scheduler;

use FluentForm\App\Services\Emogrifier\Emogrifier;
use FluentForm\View;

class Scheduler
{
    public static function processEmailReport()
    {
        self::cleanUpOldData();
        $defaults = [
            'status' => 'yes',
            'send_to_type' => 'admin_email',
            'custom_recipients' => '',
            'sending_day' => 'Mon'
        ];
        $settings = get_option('_fluentform_email_report_summary');
        if($settings) {
            $settings = wp_parse_args($settings, $defaults);
        } else {
            $settings = $defaults;
        }
        if($settings['status'] == 'no') {
            return;
        }

        $currentDay = date('D');
        $reportingDay = $settings['sending_day'];

        $config = apply_filters('fluentform_email_summary_config', [
            'status' => $currentDay == $reportingDay,
            'days' => 7
        ]);

        if (!$config['status']) {
            return;
        }

        $days = $config['days'];

        if($settings['send_to_type'] == 'admin_email') {
            $recipients = [get_option('admin_email')];
        } else {
            $custom_recipients = $settings['custom_recipients'];
            $custom_recipients = explode(',', $custom_recipients);
            $recipients = [];
            foreach ($custom_recipients as $recipient) {
                $recipient = trim($recipient);
                if(is_email($recipient)) {
                    $recipients[] = $recipient;
                }
            }
        }

        if(!$recipients) {
            return;
        }


        // Let's grab the reports
        global $wpdb;
        $days = intval($days);
        if(!$days) {
            $days = 7;
        }

        $reportDateFrom = date('Y-m-d', time() - $days * 86400); // 7 days
        $submissionCounts = wpFluent()->table('fluentform_submissions')
            ->select([
                wpFluent()->raw("COUNT({$wpdb->prefix}fluentform_submissions.id) as total"),
                'fluentform_submissions.form_id',
                'fluentform_forms.title'
            ])
            ->groupBy('fluentform_submissions.form_id')
            ->orderBy('total', 'DESC')
            ->where('fluentform_submissions.created_at', '>', $reportDateFrom)
            ->join('fluentform_forms', 'fluentform_forms.id', '=', 'fluentform_submissions.form_id')
            ->limit(15)
            ->get();

        foreach ($submissionCounts as $submissionCount) {
            $submissionCount->permalink = admin_url('admin.php?page=fluent_forms&route=entries&form_id='.$submissionCount->form_id);
        }

        if(!$submissionCounts) {
            return; // Nothing found
        }

        $paymentCounts = [];
        if(defined('FLUENTFORMPRO') && get_option('__fluentform_payment_module_settings')) {
            $paymentCounts = wpFluent()->table('fluentform_transactions')
                ->select([
                    wpFluent()->raw("SUM({$wpdb->prefix}fluentform_transactions.payment_total) as total_amount"),
                    'fluentform_transactions.form_id',
                    'fluentform_transactions.currency',
                    'fluentform_forms.title'
                ])
                ->groupBy('fluentform_transactions.form_id')
                ->orderBy('total_amount', 'DESC')
                ->where('fluentform_transactions.created_at', '>', $reportDateFrom)
                ->where('fluentform_transactions.status', '=', 'paid')
                ->join('fluentform_forms', 'fluentform_forms.id', '=', 'fluentform_transactions.form_id')
                ->limit(15)
                ->get();
            foreach ($paymentCounts as $paymentCount) {
                $paymentCount->readable_amount = $paymentCount->currency.' '.number_format($paymentCount->total_amount / 100);
            }
        }

        $data = array(
            'submissions' => $submissionCounts,
            'payments' => $paymentCounts,
            'days' => $days
        );
        $emailBody = View::make('email.report.body', $data);

        $emailBody = apply_filters('fluentform_email_summary_body', $emailBody, $data);

        $originalEmailBody = $emailBody;

        ob_start();
        try {
            // apply CSS styles inline for picky email clients
            $emogrifier = new Emogrifier($emailBody);
            $emailBody = $emogrifier->emogrify();
        } catch (\Exception $e) {

        }
        $maybeError = ob_get_clean();

        if ($maybeError) {
            $emailBody =  $originalEmailBody;
        }

        $headers = [
            'Content-Type: text/html; charset=utf-8'
        ];

        $emailSubject = sprintf( esc_html__( 'Email Summary of Your Forms (Last %d Days)', 'my-text-domain' ), $days );

        $emailSubject = apply_filters('fluentform_email_summary_subject', $emailSubject);

        $emailResult = wp_mail($recipients, $emailSubject, $emailBody, $headers);

        do_action('fluentform_email_summary_details', [
            'recipients' => $recipients,
            'email_subject' => $emailSubject,
            'email_body' => $emailBody
        ], $data, $emailResult);

        return $emailResult;
    }

    private static function cleanUpOldData()
    {
        $deleteDaysCount = apply_filters('fluentform_cleanup_days_count', 60);
        if(!$deleteDaysCount) {
            return;
        }
        $seconds = $deleteDaysCount * 86400;
        $deleteTo = date('Y-m-d H:i:s', time() - $seconds);
        // delete 60 days old analytics data
        wpFluent()->table('fluentform_form_analytics')
            ->where('created_at', '<', $deleteTo)
            ->delete();

        // delete 60 days old scheduled_actions data
        wpFluent()->table('ff_scheduled_actions')
            ->where('created_at', '<', $deleteTo)
            ->delete();

    }
}