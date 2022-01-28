<?php

namespace FluentForm\App\Modules\Settings;

use FluentForm\Framework\Request\Request;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\App\Modules\ReCaptcha\ReCaptcha;
use FluentForm\App\Modules\HCaptcha\HCaptcha;
use FluentForm\App\Services\Integrations\MailChimp\MailChimp;

/**
 * Global Settings
 *
 * @package FluentForm\App\Modules\Settings
 */
class Settings
{
    /**
     * @var \FluentForm\Framework\Request\Request
     */
    protected $request;

    /**
     * Settings constructor.
     *
     * @param \FluentForm\Framework\Request\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get a global settings for an specified key.
     */
    public function get()
    {
        $values = [];
        $key = $this->request->get('key');

        if (is_array($key)) {
            foreach ($key as $key_item) {
                $values[$key_item] = get_option($key_item);
            }
        } else {
            $values[$key] = get_option($key);
        }

        wp_send_json_success($values, 200);
    }

    public function store()
    {
        $key = $this->request->get('key');
        $method = 'store' . ucwords($key);

        $allowedMethods = [
            'storeReCaptcha',
            'storeHCaptcha',
            'storeSaveGlobalLayoutSettings',
            'storeMailChimpSettings',
            'storeEmailSummarySettings'
        ];

        if (in_array($method, $allowedMethods)) {
            $this->{$method}();
        }
    }

    public function storeReCaptcha()
    {
        $data = $this->request->get('reCaptcha');

        if ($data == 'clear-settings') {
            delete_option('_fluentform_reCaptcha_details');

            update_option('_fluentform_reCaptcha_keys_status', false, 'no');

            wp_send_json_success([
                'message' => __('Your reCaptcha settings are deleted.', 'fluentform'),
                'status'  => false
            ], 200);
        }

        $version = ArrayHelper::get($data, 'api_version');
        if($version == 'v3_invisible') {
            $captchaData = [
                'siteKey'   => sanitize_text_field(ArrayHelper::get($data, 'siteKey')),
                'secretKey' => sanitize_text_field(ArrayHelper::get($data, 'secretKey')),
                'api_version' => $version
            ];

            // Update the reCaptcha details with siteKey & secretKey.
            update_option('_fluentform_reCaptcha_details', $captchaData, 'no');

            // Update the reCaptcha validation status.
            update_option('_fluentform_reCaptcha_keys_status', true, 'no');

            wp_send_json_success([
                'message' => __('Your reCaptcha credential has been saved. Please test a real form with recaptcha enabled', 'fluentform'),
                'status'  => true
            ], 200);

        }

        $token = ArrayHelper::get($data, 'token');
        $secretKey = ArrayHelper::get($data, 'secretKey');

        // If token is not empty meaning user verified their captcha.
        if ($token) {
            // Validate the reCaptcha response.
            $status = ReCaptcha::validate($token, $secretKey);

            // reCaptcha is valid. So proceed to store.
            if ($status) {
                // Prepare captcha data.
                $captchaData = [
                    'siteKey'   => sanitize_text_field(ArrayHelper::get($data, 'siteKey')),
                    'secretKey' => sanitize_text_field($secretKey),
                    'api_version' => ArrayHelper::get($data, 'api_version')
                ];

                // Update the reCaptcha details with siteKey & secretKey.
                update_option('_fluentform_reCaptcha_details', $captchaData, 'no');

                // Update the reCaptcha validation status.
                update_option('_fluentform_reCaptcha_keys_status', $status, 'no');

                // Send success response letting the user know that
                // that the reCaptcha is valid and saved properly.
                wp_send_json_success([
                    'message' => __('Your reCaptcha is valid and saved.', 'fluentform'),
                    'status'  => $status
                ], 200);
            } else { // reCaptcha is not valid.
                $message = __('Sorry, Your reCaptcha is not valid, Please try again', 'fluentform');
            }
        } else { // The token is empty, so the user didn't verify their captcha.
            $message = __('Please validate your reCaptcha first and then hit save.', 'fluentform');

            // Get the already stored reCaptcha status.
            $status = get_option('_fluentform_reCaptcha_keys_status');

            if ($status) {
                $message = __('Your reCaptcha details are already valid, So no need to save again.', 'fluentform');
            }
        }

        wp_send_json_error([
            'message' => $message,
            'status'  => $status
        ], 400);
    }

    public function storeHCaptcha()
    {
        $data = $this->request->get('hCaptcha');

        if ($data == 'clear-settings') {
            delete_option('_fluentform_hCaptcha_details');

            update_option('_fluentform_hCaptcha_keys_status', false, 'no');

            wp_send_json_success([
                'message' => __('Your hCaptcha settings are deleted.', 'fluentform'),
                'status'  => false
            ], 200);
        }

        $token = ArrayHelper::get($data, 'token');
        $secretKey = ArrayHelper::get($data, 'secretKey');

        // If token is not empty meaning user verified their captcha.
        if ($token) {
            // Validate the hCaptcha response.
            $status = HCaptcha::validate($token, $secretKey);

            // hCaptcha is valid. So proceed to store.
            if ($status) {
                // Prepare captcha data.
                $captchaData = [
                    'siteKey'   => sanitize_text_field(ArrayHelper::get($data, 'siteKey')),
                    'secretKey' => sanitize_text_field($secretKey),
                ];

                // Update the hCaptcha details with siteKey & secretKey.
                update_option('_fluentform_hCaptcha_details', $captchaData, 'no');

                // Update the hCaptcha validation status.
                update_option('_fluentform_hCaptcha_keys_status', $status, 'no');

                // Send success response letting the user know that
                // that the hCaptcha is valid and saved properly.
                wp_send_json_success([
                    'message' => __('Your hCaptcha is valid and saved.', 'fluentform'),
                    'status'  => $status
                ], 200);
            } else { // hCaptcha is not valid.
                $message = __('Sorry, Your hCaptcha is not valid, Please try again', 'fluentform');
            }
        } else { // The token is empty, so the user didn't verify their captcha.
            $message = __('Please validate your hCaptcha first and then hit save.', 'fluentform');

            // Get the already stored hCaptcha status.
            $status = get_option('_fluentform_hCaptcha_keys_status');

            if ($status) {
                $message = __('Your hCaptcha details are already valid, So no need to save again.', 'fluentform');
            }
        }

        wp_send_json_error([
            'message' => $message,
            'status'  => $status
        ], 400);
    }

    public function storeSaveGlobalLayoutSettings()
    {
        $settings = $this->request->get('value');
        $settings = json_decode($settings, true);
        $sanitizedSettings = fluentFormSanitizer($settings);

        if (ArrayHelper::get($settings, 'misc.email_footer_text')) {
            $sanitizedSettings['misc']['email_footer_text'] = wp_unslash($settings['misc']['email_footer_text']);
        }

        update_option('_fluentform_global_form_settings', $sanitizedSettings, 'no');

        wp_send_json_success([
            'message' => __('Global layout settings has been saved')
        ], 200);
    }

    public function storeMailChimpSettings()
    {
        $mailChimp = $this->request->get('mailchimp');

        if (!$mailChimp['apiKey']) {
            $mailChimpSettings = [
                'apiKey' => '',
                'status' => false
            ];
            // Update the reCaptcha details with siteKey & secretKey.

            update_option('_fluentform_mailchimp_details', $mailChimpSettings, 'no');

            wp_send_json_success([
                'message' => __('Your settings has been updated', 'fluentform'),
                'status'  => false
            ], 200);
        }

        // Verify API key now
        try {
            $MailChimp = new MailChimp($mailChimp['apiKey']);
            $result = $MailChimp->get('lists');
            if (!$MailChimp->success()) {
                throw new \Exception($MailChimp->getLastError());
            }
        } catch (\Exception $exception) {
            wp_send_json_error([
                'message' => $exception->getMessage()
            ], 400);
        }

        // MailChimp key is verified now, Proceed now

        $mailChimpSettings = [
            'apiKey' => sanitize_text_field($mailChimp['apiKey']),
            'status' => true
        ];

        // Update the reCaptcha details with siteKey & secretKey.
        update_option('_fluentform_mailchimp_details', $mailChimpSettings, 'no');

        wp_send_json_success([
            'message' => __('Your mailchimp api key has been verfied and successfully set', 'fluentform'),
            'status'  => true
        ], 200);
    }

    public function storeEmailSummarySettings()
    {
        $defaults = [
            'status' => 'yes',
            'send_to_type' => 'admin_email',
            'custom_recipients' => '',
            'sending_day' => 'Mon'
        ];
        $settings = $this->request->get('value');
        $settings = json_decode($settings, true);

        $settings = wp_parse_args($settings, $defaults);

        update_option('_fluentform_email_report_summary', $settings);

        $emailReportHookName = 'fluentform_do_email_report_scheduled_tasks';
        if (!wp_next_scheduled($emailReportHookName)) {
            wp_schedule_event(time(), 'daily', $emailReportHookName);
        }

        wp_send_json_success([
            'message' => __('Email Summary Settings has been updated')
        ], 200);

    }
}
