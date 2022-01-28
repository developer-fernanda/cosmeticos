<?php

namespace FluentForm\App\Modules\Form\Settings\Validator;

use FluentValidator\Validator as FluentValidator;

class Pdfs
{
    /**
     * Validates mailchimp feed settings data.
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
            wp_send_json_error(['errors' => $validator->errors()], 422);
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
                'name'     => 'required',
                'template' => 'required',
                'filename' => 'required',
            ],
            [
                'name.required'     => 'The Name field is required.',
                'template.required' => 'The Template field is required.',
                'filename.required' => 'The Filename field is required.',
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
        return $validator;
    }
}
