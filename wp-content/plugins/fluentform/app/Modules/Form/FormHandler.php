<?php

namespace FluentForm\App\Modules\Form;

use FluentForm\App\Databases\Migrations\FormSubmissionDetails;
use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Activator;
use FluentForm\App\Modules\Entries\Entries;
use FluentForm\App\Modules\ReCaptcha\ReCaptcha;
use FluentForm\App\Modules\HCaptcha\HCaptcha;
use FluentForm\App\Services\Browser\Browser;
use FluentForm\App\Services\FormBuilder\ShortCodeParser;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper as Arr;
use FluentForm\Framework\Helpers\ArrayHelper;

class FormHandler
{
    /**
     * @var \FluentForm\Framework\Foundation\Application
     */
    protected $app;

    /**
     * @var \FluentForm\Framework\Request\Request
     */
    protected $request;

    /**
     * @var array $formData
     */
    protected $formData;

    /**
     * The fluent form object.
     *
     * @var \stdClass
     */
    protected $form;

    /**
     * Form Handler constructor.
     *
     * @param \FluentForm\Framework\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->request = $app->request;
    }

    /**
     * Set the form using it's ID.
     *
     * @param $formId
     * @return $this
     */
    public function setForm($formId)
    {
        $this->form = wpFluent()->table('fluentform_forms')->find($formId);
        return $this;
    }

    /**
     * Handle form submition
     */
    public function onSubmit()
    {
        // Parse the url encoded data from the request object.
        parse_str($this->app->request->get('data'), $data);

        $data['_wp_http_referer'] = urldecode( $data['_wp_http_referer'] );

        // Merge it back again to the request object.
        $this->app->request->merge(['data' => $data]);

        $formId = intval($this->app->request->get('form_id'));

        $this->setForm($formId);

        if (!$this->form) {
            wp_send_json([
                'errors' => [],
                'message' => 'Sorry, No corresponding form found'
            ], 423);
        }

        // Parse the form and get the flat inputs with validations.
        $fields = FormFieldsParser::getInputs($this->form, ['rules', 'raw']);

        // Sanitize the data properly.
        $this->formData = fluentFormSanitizer($data, null, $fields);

        // Now validate the data using the previous validations.
        $this->validate($fields);

        // Prepare the data to be inserted to the DB.
        $insertData = $this->prepareInsertData();

        if ($this->isSpam($this->formData, $this->form)) {
            $insertData['status'] = 'spam';
            $this->handleSpamError();
        }

        do_action('fluentform_before_insert_submission', $insertData, $data, $this->form);

        if ($this->form->has_payment) {
            do_action('fluentform_before_insert_payment_form', $insertData, $data, $this->form);
        }

        $insertId = wpFluent()->table('fluentform_submissions')->insert($insertData);

        $uidHash = md5(wp_generate_uuid4() . $insertId);
        Helper::setSubmissionMeta($insertId, '_entry_uid_hash', $uidHash, $formId);

        do_action('fluentform_before_form_actions_processing', $insertId, $this->formData, $this->form);

        $result = $this->processFormSubmissionData($insertId, $this->formData, $this->form);

        wp_send_json_success($result, 200);
    }

    public function processFormSubmissionData($insertId, $formData, $form)
    {
        if ($insertId) {
            ob_start();
            $entries = new Entries();
            $entries->recordEntryDetails($insertId, $form->id, $formData);
            $isError = ob_get_clean();
            if ($isError) {
                FormSubmissionDetails::migrate();
            }
        }

        $returnData = $this->getReturnData($insertId, $form, $formData);

        $error = '';
        try {
            $this->app->doAction(
                'fluentform_submission_inserted',
                $insertId,
                $formData,
                $form
            );

            Helper::setSubmissionMeta($insertId, 'is_form_action_fired', 'yes');

            $this->app->doAction(
                'fluentform_submission_inserted_' . $form->type . '_form',
                $insertId,
                $formData,
                $form
            );
        } catch (\Exception $e) {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                $error = $e->getMessage();
            }
        }

        do_action('fluentform_before_submission_confirmation', $insertId, $formData, $form);

        // that was a typo. We will remove that after september
        // @todo: Remove this action after september 2021
        do_action('fluenform_before_submission_confirmation', $insertId, $formData, $form);

        return [
            'insert_id' => $insertId,
            'result' => $returnData,
            'error' => $error
        ];
    }

    public function getReturnData($insertId, $form, $formData)
    {
        if (empty($form->settings)) {
            $formSettings = wpFluent()->table('fluentform_form_meta')
                ->where('form_id', $form->id)
                ->where('meta_key', 'formSettings')
                ->first();

            $form->settings = $formSettings ? json_decode($formSettings->value, true) : [];
        }


        $confirmation = apply_filters(
            'fluentform_form_submission_confirmation',
            $form->settings['confirmation'],
            $formData,
            $form
        );

        if ($confirmation['redirectTo'] == 'samePage') {

            $confirmation['messageToShow'] = apply_filters('fluentform_submission_message_parse', $confirmation['messageToShow'], $insertId, $formData, $form);


            $message = ShortCodeParser::parse(
                $confirmation['messageToShow'],
                $insertId,
                $formData,
                $form
            );


            $message = $message ? $message : 'The form has been successfully submitted.';

            $returnData = [
                'message' => do_shortcode($message),
                'action' => $confirmation['samePageFormBehavior'],
            ];

        } else {
            $redirectUrl = Arr::get($confirmation, 'customUrl');

            if ($confirmation['redirectTo'] == 'customPage') {
                $redirectUrl = get_permalink($confirmation['customPage']);
            }

            if (
                (Arr::get($confirmation, 'enable_query_string') == 'yes') &&
                Arr::get($confirmation, 'query_strings')
            ) {
                if (strpos($redirectUrl, '?')) {
                    $redirectUrl .= '&' . Arr::get($confirmation, 'query_strings');
                } else {
                    $redirectUrl .= '?' . Arr::get($confirmation, 'query_strings');
                }
            }

            $isUrlParser = apply_filters('fluentform_will_parse_url_value', true, $form);

            $redirectUrl = ShortCodeParser::parse(
                $redirectUrl,
                $insertId,
                $formData,
                $form,
                $isUrlParser
            );

            if($isUrlParser) {
                /*
                 * For Empty Redirect Value
                 */
                if(strpos($redirectUrl, '=&') || substr($redirectUrl, -1) == '=') {
                    $urlArray = explode('?', $redirectUrl);
                    $baseUrl = array_shift($urlArray);

                    $query = wp_parse_url($redirectUrl)['query'];

                    $queryParams = explode('&', $query);

                    $params = [];
                    foreach ($queryParams as $queryParam) {
                        $paramArray = explode('=', $queryParam);
                        if(!empty($paramArray[1])) {
                            $params[$paramArray[0]] = $paramArray[1];
                        }
                    }

                    $redirectUrl = add_query_arg($params, $baseUrl);
                }
            }

            $message = ShortCodeParser::parse(
                ArrayHelper::get($confirmation, 'redirectMessage', ''),
                $insertId,
                $formData,
                $form
            );

            $returnData = [
                'redirectUrl' => wp_sanitize_redirect(urldecode($redirectUrl)),
                'message' => $message
            ];
        }

        return $this->app->applyFilters(
            'fluentform_submission_confirmation',
            $returnData,
            $form,
            $confirmation
        );
    }

    /**
     * Validate form data.
     *
     * @param $fields
     * @return bool
     */
    private function validate(&$fields)
    {
		$this->preventMaliciousAttacks();

        $this->validateRestrictions($fields);

        $this->validateNonce();

        $this->validateReCaptcha();
        $this->validateHCaptcha();
//        dd('ok');

        foreach ($fields as $fieldName => $field) {
            if(isset($this->formData[$fieldName])) {
                $element = $field['element'];
                $this->formData[$fieldName] = apply_filters('fluentform_input_data_'.$element, $this->formData[$fieldName], $field, $this->formData, $this->form);
            }
        }

        $originalValidations = FormFieldsParser::getValidations($this->form, $this->formData, $fields);

        // Fire an event so that one can hook into it to work with the rules & messages.
        $validations = apply_filters('fluentform_validations', $originalValidations, $this->form, $this->formData);

        /*
         * Clean talk fix for now
        * They should not hook fluentform_validations and return nothing!
        * We will remove this extra check once it's done
         */
        if ($originalValidations && (!$validations || !array_filter($validations))) {
            $validations = $originalValidations;
        }

        $validator = \FluentValidator\Validator::make($this->formData, $validations[0], $validations[1]);

        $errors = [];
        if ($validator->validate()->fails()) {
            foreach ($validator->errors() as $attribute => $rules) {
                $position = strpos($attribute, ']');

                if ($position) {
                    $attribute = substr($attribute, 0, strpos($attribute, ']') + 1);
                }

                $errors[$attribute] = $rules;
            }
            // Fire an event so that one can hook into it to work with the errors.
            $errors = $this->app->applyFilters('fluentform_validation_error', $errors, $this->form, $fields, $this->formData);
        }

        foreach ($fields as $fieldKey => $field) {
            $field['data_key'] = $fieldKey;
            $inputName = \FluentForm\Framework\Helpers\ArrayHelper::get($field, 'raw.attributes.name');
            $field['name'] = $inputName;
            $error = apply_filters('fluentform_validate_input_item_' . $field['element'], '', $field, $this->formData, $fields, $this->form, $errors);
            if ($error) {
                if (empty($errors[$inputName])) {
                    $errors[$inputName] = [];
                }

                if(is_string($error)) {
                    $error = [$error];
                }

                $errors[$inputName] = array_merge($error, $errors[$inputName]);
            }
        }

        $errors = apply_filters('fluentform_validation_errors', $errors, $this->formData, $this->form, $fields);

        if(Helper::getFormMeta($this->form->id, '_has_user_registration') == 'yes') {
            $errors = apply_filters('fluentform_validation_user_registration_errors', $errors, $this->formData, $this->form, $fields);
        }

        if ($errors) {
            wp_send_json(['errors' => $errors], 423);
        }

        return true;
    }

    /**
     * Validate nonce.
     */
    protected function validateNonce()
    {
        $formId = $this->form->id;

        $shouldVerifyNonce = $this->app->applyFilters('fluentform_nonce_verify', false, $formId);

        if ($shouldVerifyNonce) {
            $nonce = Arr::get($this->formData, '_fluentform_' . $formId . '_fluentformnonce');
            if (!wp_verify_nonce($nonce, 'fluentform-submit-form')) {
                $errors = $this->app->applyFilters('fluentForm_nonce_error', [
                    '_fluentformnonce' => [
                        __('Nonce verification failed, please try again.', 'fluentform')
                    ]
                ]);
                wp_send_json(['errors' => $errors], 422);
            }
        }
    }

    protected function handleSpamError()
    {
        $settings = get_option('_fluentform_global_form_settings');
        if (!$settings || ArrayHelper::get($settings, 'misc.akismet_validation') != 'validation_failed') {
            return;
        }

        $errors =  [
            '_fluentformakismet' => __('Submission marked as spammed. Please try again', 'fluentform')
        ];

        wp_send_json(['errors' => $errors], 422);
    }

    protected function isSpam($formData, $form)
    {
        if (!AkismetHandler::isEnabled()) {
            return false;
        }

        $isSpamCheck = apply_filters('fluentform_akismet_check_spam', true, $form->id, $formData);
        if (!$isSpamCheck) {
            return false;
        }
        // Let's validate now
        $isSpam = AkismetHandler::isSpamSubmission($formData, $form);

        return apply_filters('fluentform_akismet_spam_result', $isSpam, $form->id, $formData);
    }

    /**
     * Validate reCaptcha.
     */
    private function validateReCaptcha()
    {
        if (FormFieldsParser::hasElement($this->form, 'recaptcha')) {
            $keys = get_option('_fluentform_reCaptcha_details');
            $token = Arr::get($this->formData, 'g-recaptcha-response');
            $version = 'v2_visible';
            if(!empty($keys['api_version'])) {
                $version = $keys['api_version'];
            }
            $isValid = ReCaptcha::validate($token, $keys['secretKey'], $version);

            if (!$isValid) {
                wp_send_json([
                    'errors' => [
                        'g-recaptcha-response' => [
                            __('reCaptcha verification failed, please try again.', 'fluentform')
                        ]
                    ]
                ], 422);
            }
        }
    }

    /**
     * Validate hCaptcha.
     */
    private function validateHCaptcha()
    {
        FormFieldsParser::resetData();
        if (FormFieldsParser::hasElement($this->form, 'hcaptcha')) {
            $keys = get_option('_fluentform_hCaptcha_details');
            $token = Arr::get($this->formData, 'h-captcha-response');
            $isValid = HCaptcha::validate($token, $keys['secretKey']);

            if (!$isValid) {
                wp_send_json([
                    'errors' => [
                        'h-captcha-response' => [
                            __('hCaptcha verification failed, please try again.', 'fluentform')
                        ]
                    ]
                ], 422);
            }
        }
    }

    /**
     * Validate form data based on the form restrictions settings.
     *
     * @param $fields
     */
    private function validateRestrictions(&$fields)
    {
        $formSettings = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $this->form->id)
            ->where('meta_key', 'formSettings')
            ->first();

        $this->form->settings = $formSettings ? json_decode($formSettings->value, true) : [];

        $isAllowed = [
            'status' => true,
            'message' => ''
        ];

        // This will check the following restriction settings.
        // 1. limitNumberOfEntries
        // 2. scheduleForm
        // 3. requireLogin
        $isAllowed = apply_filters('fluentform_is_form_renderable', $isAllowed, $this->form);

        if (!$isAllowed['status']) {
            wp_send_json([
                'errors' => [
                    'restricted' => [
                        $isAllowed['message']
                    ]
                ]
            ], 422);
        }

        // Since we are here, we should now handle if the form should be allowed to submit empty.
        $restrictions = Arr::get($this->form->settings, 'restrictions.denyEmptySubmission', []);

        $this->handleDenyEmptySubmission($restrictions, $fields);
    }

    /**
     * Handle response when empty form submission is not allowed.
     *
     * @param array $settings
     * @param $fields
     */
    private function handleDenyEmptySubmission($settings, &$fields)
    {
        // Determine whether empty form submission is allowed or not.
        if (Arr::get($settings, 'enabled')) {
            // confirm this form has no required fields.
            if (!FormFieldsParser::hasRequiredFields($this->form, $fields)) {
                // Filter out the form data which doesn't have values.
                $filteredFormData = array_filter(
                // Filter out the other meta fields that aren't actual inputs.
                    array_intersect_key($this->formData, $fields)
                );

                // TODO: Extract this function into global functions file...
                $arrayFilterRecursive = function ($array) use (&$arrayFilterRecursive) {
                    foreach ($array as $key => $item) {
                        is_array($item) && $array[$key] = $arrayFilterRecursive($item);
                        if (empty($array[$key])) {
                            unset($array[$key]);
                        }
                    }
                    return $array;
                };

                if (!count($arrayFilterRecursive($filteredFormData))) {
                    wp_send_json([
                        'errors' => [
                            'restricted' => [
                                __(
                                    !($m = Arr::get($settings, 'message'))
                                        ? 'Sorry! You can\'t submit an empty form.'
                                        : $m,
                                    'fluentform'
                                )
                            ]
                        ]
                    ], 422);
                }
            }
        }
    }

    /**
     * Prepare the data to be inserted to the database.
     *
     * @param boolean $formData
     * @return array
     */
    public function prepareInsertData($formData = false)
    {
        $formId = $this->form->id;

        if (!$formData) {
            $formData = $this->formData;
        }

        $previousItem = wpFluent()->table('fluentform_submissions')
            ->where('form_id', $formId)
            ->orderBy('id', 'DESC')
            ->first();

        $serialNumber = 1;

        if ($previousItem) {
            $serialNumber = $previousItem->serial_number + 1;
        }

        $browser = new Browser;

        $inputConfigs = FormFieldsParser::getEntryInputs($this->form, array('admin_label', 'raw'));

        $this->formData = apply_filters('fluentform_insert_response_data', $formData, $formId, $inputConfigs);

        $ipAddress = $this->app->request->getIp();

        if ((defined('FLUENTFROM_DISABLE_IP_LOGGING') && FLUENTFROM_DISABLE_IP_LOGGING) || apply_filters('fluentform_disable_ip_logging', false, $formId)) {
            $ipAddress = false;
        }

        $response = [
            'form_id' => $formId,
            'serial_number' => $serialNumber,
            'response' => json_encode($this->formData),
            'source_url' => site_url(Arr::get($formData, '_wp_http_referer')),
            'user_id' => get_current_user_id(),
            'browser' => $browser->getBrowser(),
            'device' => $browser->getPlatform(),
            'ip' => $ipAddress,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        ];


        return apply_filters('fluentform_filter_insert_data', $response);
    }

    /**
     * Delegate the validation rules & messages to the
     * ones that the validation library recognizes.
     *
     * @param  $rules
     * @param  $messages
     * @return array
     */
    protected function delegateValidations($rules, $messages, $search = [], $replace = [])
    {
        $search = $search ?: ['max_file_size', 'allowed_file_types'];
        $replace = $replace ?: ['max', 'mimes'];

        foreach ($rules as &$rule) {
            $rule = str_replace($search, $replace, $rule);
        }

        foreach ($messages as $key => $message) {
            $newKey = str_replace($search, $replace, $key);
            $messages[$newKey] = $message;
            unset($messages[$key]);
        }

        return [$rules, $messages];
    }

	/**
	 * Prevents malicious attacks when the submission
	 * count exceeds in an allowed interval.
	 */
	public function preventMaliciousAttacks()
	{
		$prevent = apply_filters('fluentform/prevent_malicious_attacks', true, $this->form->id);

		if ($prevent) {
			$maxSubmissionCount = apply_filters('fluentform/max_submission_count', 5, $this->form->id);
			$minSubmissionInterval = apply_filters('fluentform/min_submission_interval', 30, $this->form->id);

			$interval = date('Y-m-d H:i:s', strtotime(current_time('mysql')) - $minSubmissionInterval);

			$submissionCount = wpFluent()->table('fluentform_submissions')
				->where('status', '!=', 'trashed')
				->where('ip', $this->app->request->getIp())
				->where('created_at', '>=', $interval)
				->count();

			if ($submissionCount >= $maxSubmissionCount) {
				wp_send_json([
					'errors' => [
						'restricted' => [
							__(apply_filters('fluentform/too_many_requests', 'Too Many Requests.', $this->form->id), 'fluentform')
						]
					]
				], 429);
			}
		}
	}
}
