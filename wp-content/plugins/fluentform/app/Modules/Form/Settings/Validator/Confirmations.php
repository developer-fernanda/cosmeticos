<?php

namespace FluentForm\App\Modules\Form\Settings\Validator;

use FluentValidator\Validator as FluentValidator;

class Confirmations
{
    /**
     * Validates confirmations settings data.
     *
     * @param array $data
     *
     * @return bool
     */
    public static function validate($data = [])
    {
        // Prepare the validation rules & messages.
        list($rules, $messages) = static::validations();

        // Make validator instance.
        $validator = FluentValidator::make($data, $rules, $messages);

        // Add conditional validations if there's any.
        $validator = static::conditionalValidations($validator);

        // Validate and process response.
        if ($validator->validate()->fails()) {
            wp_send_json_error([
                'errors' => $validator->errors()
            ], 422);
        }

        return true;
    }

    /**
     * Produce the necessary validation rules and corresponding messages
     *
     * @return array
     */
    public static function validations()
    {
        return [
            [
                'redirectTo' => 'required',
                'customPage' => 'required_if:redirectTo,customPage',
                'customUrl' => 'required_if:redirectTo,customUrl',
            ],
            [
                'redirectTo.required' => __('The Confirmation Type field is required.', 'fluentform'),
                'customPage.required_if' => __('The Page field is required when Confirmation Type is Page.', 'fluentform'),
                'customUrl.required_if' => __('The Redirect URL field is required when Confirmation Type is Redirect.', 'fluentform'),
                'customUrl.required' => __('The Redirect URL format is invalid.', 'fluentform'),
            ]
        ];
    }

    /**
     * Add conditional validations to the validator.
     *
     * @param FluentValidator $validator
     *
     * @return FluentValidator
     */
    public static function conditionalValidations(FluentValidator $validator)
    {
        $validator->sometimes('customUrl', 'required', function ($input) {
            return $input['redirectTo'] === 'customUrl';
        });

        return $validator;
    }
}
