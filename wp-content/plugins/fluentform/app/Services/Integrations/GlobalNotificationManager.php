<?php

namespace FluentForm\App\Services\Integrations;

use FluentForm\App\Databases\Migrations\ScheduledActions;
use FluentForm\App\Modules\Form\FormDataParser;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\ConditionAssesor;
use FluentForm\App\Services\FormBuilder\ShortCodeParser;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class GlobalNotificationManager
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function globalNotify($insertId, $formData, $form)
    {
        // Let's find the feeds that are available for this form
        $feedKeys = apply_filters('fluentform_global_notification_active_types', [], $form->id);

        if (!$feedKeys) {
            do_action('fluentform_global_notify_completed', $insertId, $form);
            return;
        }

        $feedMetaKeys = array_keys($feedKeys);


        $feeds = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $form->id)
            ->whereIn('meta_key', $feedMetaKeys)
            ->orderBy('id', 'ASC')
            ->get();

        if (!$feeds) {
            do_action('fluentform_global_notify_completed', $insertId, $form);
            return;
        }

        // Now we have to filter the feeds which are enabled
        $enabledFeeds = [];
        foreach ($feeds as $feed) {
            $parsedValue = json_decode($feed->value, true);
            if ($parsedValue && ArrayHelper::isTrue($parsedValue, 'enabled')) {
                // Now check if conditions matched or not
                $isConditionMatched = $this->checkCondition($parsedValue, $formData, $insertId);
                if ($isConditionMatched) {
                    $item = [
                        'id'       => $feed->id,
                        'meta_key' => $feed->meta_key,
                        'settings' => $parsedValue
                    ];
                    if($feed->meta_key == 'user_registration_feeds') {
                        array_unshift($enabledFeeds , $item);
                    } else {
                        $enabledFeeds[] = $item;
                    }
                }
            }
        }

        if(!$enabledFeeds) {
            do_action('fluentform_global_notify_completed', $insertId, $form);
            return;
        }

        $entry = false;
        $asyncFeeds = [];

        foreach ($enabledFeeds as $feed) {
            // We will decide if this feed will run on async or sync
            $integrationKey = ArrayHelper::get($feedKeys, $feed['meta_key']);

            $action = 'fluentform_integration_notify_' . $feed['meta_key'];

            if (!$entry) {
                $entry = $this->getEntry($insertId, $form);
            }

            // It's sync
            $processedValues = $feed['settings'];
            unset($processedValues['conditionals']);
            $processedValues = ShortCodeParser::parse($processedValues, $insertId, $formData, $form, false, $feed['meta_key']);
            $feed['processedValues'] = $processedValues;

            if (apply_filters('fluentform_notifying_async_' . $integrationKey, true, $form->id)) {
                // It's async
                $asyncFeeds[] = [
                    'action' => $action,
                    'form_id' => $form->id,
                    'origin_id' => $insertId,
                    'feed_id' => $feed['id'],
                    'type' => 'submission_action',
                    'status' => 'pending',
                    'data' => maybe_serialize($feed),
                    'created_at' => current_time('mysql'),
                    'updated_at' => current_time('mysql')
                ];
            } else {
                do_action($action, $feed, $formData, $entry, $form);
            }
        }

        if (!$asyncFeeds) {
            do_action('fluentform_global_notify_completed', $insertId, $form);
            return;
        }

        // Now we will push this async feeds
        $handler = $this->app['fluentFormAsyncRequest'];
        $handler->queueFeeds( $asyncFeeds);

        $handler->dispatchAjax(['origin_id' => $insertId]);
    }

    public function checkCondition($parsedValue, $formData, $insertId)
    {
        $conditionSettings = ArrayHelper::get($parsedValue, 'conditionals');
        if (
            !$conditionSettings ||
            !ArrayHelper::isTrue($conditionSettings, 'status') ||
            !count(ArrayHelper::get($conditionSettings, 'conditions'))
        ) {
            return true;
        }

        return ConditionAssesor::evaluate($parsedValue, $formData);
    }

    private function getEntry($id, $form)
    {
        $submission = wpFluent()->table('fluentform_submissions')->find($id);
        $formInputs = FormFieldsParser::getEntryInputs($form, ['admin_label', 'raw']);
        return FormDataParser::parseFormEntry($submission, $form, $formInputs);
    }

    public function cleanUpPassword($entryId, $form)
    {
        // Let's get the password fields
        $inputs = FormFieldsParser::getInputsByElementTypes($form, ['input_password']);

        if(!$inputs) {
            return;
        }
        $passwordKeys = array_keys($inputs);

        // Let's delete from entry details
        wpFluent()->table('fluentform_entry_details')
            ->where('form_id', $form->id)
            ->whereIn('field_name', $passwordKeys)
            ->where('submission_id', $entryId)
            ->delete();

        // Let's alter from main submission data
        $submission = wpFluent()->table('fluentform_submissions')
                        ->where('id', $entryId)
                        ->first();

        if(!$submission) {
            return;
        }

        $responseInputs = \json_decode($submission->response, true);

        $replaced = false;
        foreach ($passwordKeys as $passwordKey) {
            if(!empty($responseInputs[$passwordKey])) {
                $originalPassword = $responseInputs[$passwordKey];
                $responseInputs[$passwordKey] = str_repeat("*", strlen($originalPassword)).' '. __('(truncated)', 'fluentform');
                $replaced = true;
            }
        }

        if($replaced) {
            wpFluent()->table('fluentform_submissions')
                ->where('id', $entryId)
                ->update([
                    'response' => \json_encode($responseInputs)
                ]);
        }
    }
}
