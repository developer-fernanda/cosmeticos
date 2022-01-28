<?php

namespace FluentForm\App\Modules\Form\Settings;

use FluentForm\App\Modules\Acl\Acl;
use FluentForm\App\Modules\Form\Form;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\Framework\Foundation\Application;
use FluentForm\App\Modules\Form\Settings\Validator\Validator;

class FormSettings
{
    /**
     * @var \FluentForm\Framework\Request\Request
     */
    private $request;

    private $app;

    /**
     * @var int form ID.
     */
    private $formId;

    /**
     * The settings (fluentform_form_meta) query builder.
     *
     * @var \WpFluent\QueryBuilder\QueryBuilderHandler
     */
    private $settingsQuery;

    /**
     * Construct the object
     * @throws \Exception
     */
    public function __construct(Application $application)
    {
        $this->app = $application;

        $this->request = $application->request;
        $this->formId = intval($this->request->get('form_id'));

        $this->settingsQuery = wpFluent()->table('fluentform_form_meta')->where('form_id', $this->formId);
    }

    /**
     * Get settings for a particular form by id
     * @return void
     */
    public function index()
    {
        $metaKey = sanitize_text_field($this->request->get('meta_key'));

        // We'll always try to get a collection for a given meta key.
        // Acknowledging that a certain meta key can have multiple
        // results. The developer using the api knows beforehand
        // that whether the expected result contains multiple
        // or one value. The developer will access that way.
        $query = $this->settingsQuery->where('meta_key', $metaKey);

        $result = $query->get();

        foreach ($result as $item) {
            $item->value = json_decode($item->value, true);
            if($metaKey == 'notifications') {
                if(!$item->value) {
                    $item->value = ['name' => ''];
                }
            }
            if (isset($item->value['layout']) && !isset($item->value['layout']['asteriskPlacement'])) {
                $item->value['layout']['asteriskPlacement'] = 'asterisk-right';
            }
        }

        wp_send_json_success(['result' => $result], 200);
    }


    public function getGeneralSettingsAjax()
    {
        $formId = intval($this->request->get('form_id'));
        $form = new Form($this->app);
        $settings = [
            'generalSettings' => $form->getFormsDefaultSettings($formId),
            'advancedValidationSettings' => $form->getAdvancedValidationSettings($formId)
        ];

        $settings = apply_filters('fluentform_form_settings_ajax', $settings, $formId);

        wp_send_json_success($settings, 200);
    }

    public function saveGeneralSettingsAjax()
    {
        $formId = intval($this->request->get('form_id'));
        $form = new Form($this->app);
        $formSettings = \json_decode($this->request->get('formSettings'), true);
        $advancedValidationSettings = \json_decode($this->request->get('advancedValidationSettings'), true);

        Validator::validate(
            'confirmations',
            ArrayHelper::get($formSettings, 'confirmation', [])
        );

        $form->updateMeta($formId, 'formSettings', $formSettings);
        $form->updateMeta($formId, 'advancedValidationSettings', $advancedValidationSettings);

        $deleteAfterXDaysStatus = ArrayHelper::get($formSettings, 'delete_after_x_days');
        $deleteDaysCount = ArrayHelper::get($formSettings, 'auto_delete_days');
        $deleteOnSubmission = ArrayHelper::get($formSettings, 'delete_entry_on_submission');

        if($deleteOnSubmission != 'yes' && $deleteDaysCount && $deleteAfterXDaysStatus == 'yes') {
            // We have to set meta values
            $form->updateMeta($formId, 'auto_delete_days', intval($deleteDaysCount));
        } else {
            // we have to delete meta values
            $form->deleteMeta($formId, 'auto_delete_days');
        }

        do_action('fluentform_after_save_form_settings', $formId, $this->request->all());

        wp_send_json_success([
            'message' => __('Settings has been saved.', 'fluentform')
        ], 200);

    }

    /**
     * Save settings/meta for a form in database
     */
    public function store()
    {
        $value = $this->request->get('value', '');

        $valueArray = $value ? json_decode($value, true) : [];

        $key = sanitize_text_field($this->request->get('meta_key'));

        if ($key == 'formSettings') {
            Validator::validate(
                'confirmations', ArrayHelper::get(
                $valueArray, 'confirmation', []
            )
            );
        } else {
            Validator::validate($key, $valueArray);
        }

        $data = [
            'meta_key' => $key,
            'value' => $value,
            'form_id' => $this->formId
        ];

        // If the request has an valid id field it's safe to assume
        // that the user wants to update an existing settings.
        // So, we'll proceed to do so by finding it first.
        $id = intval($this->request->get('id'));

        if ($id) {
            $settings = $this->settingsQuery->find($id);
        }

        if (isset($settings)) {
            $this->settingsQuery->where('id', $settings->id)->update($data);
            $insertId = $settings->id;
        } else {
            $insertId = $this->settingsQuery->insert($data);
        }

        wp_send_json_success([
            'message' => __('Settings has been saved.', 'fluentform'),
            'settings' => json_decode($value, true),
            'id' => $insertId
        ], 200);
    }

    /**
     * Delete settings/meta from database for a given form
     * @return void
     */
    public function remove()
    {
        $id = intval($this->request->get('id'));

        $this->settingsQuery->where('id', $id)->delete();

        wp_send_json([], 200);
    }
}
