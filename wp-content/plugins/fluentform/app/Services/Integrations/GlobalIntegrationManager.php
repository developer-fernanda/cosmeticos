<?php

namespace FluentForm\App\Services\Integrations;

use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class GlobalIntegrationManager
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getGlobalSettingsAjax()
    {
        $settingsKey = sanitize_text_field($_REQUEST['settings_key']);
        $settings = apply_filters('fluentform_global_integration_settings_' . $settingsKey, []);
        $fieldSettings = apply_filters('fluentform_global_integration_fields_' . $settingsKey, []);

        if (!$fieldSettings) {
            wp_send_json_error([
                'settings'     => $settings,
                'settings_key' => $settingsKey,
                'message'      => __('Sorry! No integration failed found with: ', 'fluentform') . $settingsKey
            ], 423);
        }

        if (empty($fieldSettings['save_button_text'])) {
            $fieldSettings['save_button_text'] = __('Save Settings', 'fluentform');
        }

        if (empty($fieldSettings['valid_message'])) {
            $fieldSettings['valid_message'] = __('Your API Key is valid', 'fluentform');
        }

        if (empty($fieldSettings['invalid_message'])) {
            $fieldSettings['invalid_message'] = __('Your API Key is not valid', 'fluentform');
        }

        wp_send_json_success([
            'integration' => $settings,
            'settings'    => $fieldSettings
        ], 200);

    }

    public function saveGlobalSettingsAjax()
    {
        $settingsKey = sanitize_text_field($_REQUEST['settings_key']);
        $integration = wp_unslash($_REQUEST['integration']);
        do_action('fluentform_save_global_integration_settings_' . $settingsKey, $integration);

        // Someone should catch that above action and send response
        wp_send_json_error([
            'message' => __('Sorry, no Integration found. Please make sure that latest version of WP Fluent Form pro installed', 'wpfluentform')
        ], 423);

    }

    public function getAllFormIntegrations()
    {
        $formId = $this->app->request->get('form_id');

        $formattedFeeds = $this->getNotificationFeeds($formId);

        $availableIntegrations = apply_filters('fluentform_get_available_form_integrations', [], $formId);

        wp_send_json_success([
            'feeds'                  => $formattedFeeds,
            'available_integrations' => $availableIntegrations,
            'all_module_config_url'  => admin_url('admin.php?page=fluent_forms_add_ons')
        ], 200);

    }

    public function getNotificationFeeds($formId)
    {
        $notificationKeys = apply_filters('fluentform_global_notification_types', [], $formId);

        if ($notificationKeys) {
            $feeds = wpFluent()->table('fluentform_form_meta')
                ->where('form_id', $formId)
                ->whereIn('meta_key', $notificationKeys)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $feeds = [];
        }

        $formattedFeeds = [];

        foreach ($feeds as $feed) {
            $data = json_decode($feed->value, true);
            $enabled = $data['enabled'];
            if ($enabled && $enabled == 'true') {
                $enabled = true;
            } else if ($enabled == 'false') {
                $enabled = false;
            }
            $feedData = [
                'id'       => $feed->id,
                'name'     => ArrayHelper::get($data, 'name'),
                'enabled'  => $enabled,
                'provider' => $feed->meta_key,
                'feed'     => $data
            ];
            $feedData = apply_filters('fluentform_global_notification_feed_' . $feed->meta_key, $feedData, $formId);
            $formattedFeeds[] = $feedData;
        }
        return $formattedFeeds;
    }

    public function updateNotificationStatus()
    {
        $formId = intval($this->app->request->get('form_id'));
        $notificationId = intval($this->app->request->get('notification_id'));
        $status = sanitize_key($this->app->request->get('status'));

        $feed = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('id', $notificationId)
            ->first();

        $notification = json_decode($feed->value, true);


        if ($status == 'false' || !$status) {
            $notification['enabled'] = false;
        } else {
            $notification['enabled'] = true;
        }

        wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('id', $notificationId)
            ->update([
                'value' => json_encode($notification, JSON_NUMERIC_CHECK)
            ]);

        $feed = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('id', $notificationId)
            ->first();


        wp_send_json_success([
            'message' => __('Integration successfully updated', 'fluentform')
        ], 200);

    }

    public function getIntegrationSettings()
    {
        $integrationName = $this->app->request->get('integration_name');
        $integrationId = intval($this->app->request->get('integration_id'));
        $formId = intval($this->app->request->get('form_id'));

        $settings = [
            'conditionals' => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'enabled'      => true,
            'list_id'      => '',
            'list_name'    => '',
            'name'         => '',
            'merge_fields' => []
        ];

        $mergeFields = false;
        if ($integrationId) {
            $feed = wpFluent()->table('fluentform_form_meta')
                ->where('form_id', $formId)
                ->where('id', $integrationId)
                ->first();

            if ($feed->value) {
                $settings = json_decode($feed->value, true);

                $settings = apply_filters('fluentform_get_integration_values_' . $integrationName, $settings, $feed, $formId);
                if (!empty($settings['list_id'])) {
                    $mergeFields = apply_filters('fluentform_get_integration_merge_fields_' . $integrationName, false, $settings['list_id'], $formId);
                }
            }
        } else {
            $settings = apply_filters('fluentform_get_integration_defaults_' . $integrationName, $settings, $formId);
        }

        if ($settings['enabled'] == 'true') {
            $settings['enabled'] = true;
        } else if ($settings['enabled'] == 'false' || $settings['enabled']) {
            $settings['enabled'] = false;
        }

        $settingsFields = apply_filters('fluentform_get_integration_settings_fields_' . $integrationName, [], $formId, $settings);


        wp_send_json_success([
            'settings'        => $settings,
            'settings_fields' => $settingsFields,
            'merge_fields'    => $mergeFields
        ], 200);

    }

    public function saveIntegrationSettings()
    {
        $integrationName = $this->app->request->get('integration_name');
        $integrationId = intval($this->app->request->get('integration_id'));
        $formId = intval($this->app->request->get('form_id'));

        if ($this->app->request->get('data_type') == 'stringify') {
            $integration = \json_decode($this->app->request->get('integration'), true);
        } else {
            $integration = wp_unslash($_REQUEST['integration']);
        }

        if ($integration['enabled'] && $integration['enabled'] == 'true') {
            $integration['status'] = true;
        }

        if (!$integration['name']) {
            wp_send_json_error([
                'message' => 'Validation Failed',
                'errors'  => [
                    'name' => ['Feed name is required']
                ]
            ], 423);
        }

        $integration = apply_filters('fluentform_save_integration_value_' . $integrationName, $integration, $integrationId, $formId);

        $data = [
            'form_id'  => $formId,
            'meta_key' => $integrationName . '_feeds',
            'value'    => \json_encode($integration)
        ];

        $data = apply_filters('fluentform_save_integration_settings_' . $integrationName, $data, $integrationId);

        $created = false;
        if ($integrationId) {
            wpFluent()->table('fluentform_form_meta')
                ->where('form_id', $formId)
                ->where('id', $integrationId)
                ->update($data);
        } else {
            $created = true;
            $integrationId = wpFluent()->table('fluentform_form_meta')
                ->insert($data);
        }

        wp_send_json_success([
            'message'          => __('Integration successfully saved', 'fluentform'),
            'integration_id'   => $integrationId,
            'integration_name' => $integrationName,
            'created'          => $created
        ], 200);
    }

    public function deleteIntegrationFeed()
    {
        $formId = intval($this->app->request->get('form_id'));
        $integrationId = intval($this->app->request->get('integration_id'));

        wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('id', $integrationId)
            ->delete();

        wp_send_json_success([
            'message' => __('Selected integration feed successfully deleted', 'fluentform')
        ]);
    }

    public function getIntegrationList()
    {
        $integrationName = $this->app->request->get('integration_name');
        $formId = intval($this->app->request->get('form_id'));
        $listId = $this->app->request->get('list_id');
        $merge_fields = apply_filters('fluentform_get_integration_merge_fields_' . $integrationName, false, $listId, $formId);

        wp_send_json_success([
            'merge_fields' => $merge_fields
        ], 200);

    }
}
