<?php

namespace FluentForm\App\Modules\Form\Settings\Validator;

use FluentForm\Framework\Helpers\ArrayHelper;
use FluentValidator\Validator as FluentValidator;

class Notifications
{
    /**
     * Validates notifications settings data.
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
                'sendTo.type'  => 'required',
                'sendTo.email' => 'required_if:sendTo.type,email',
                'sendTo.field' => 'required_if:sendTo.type,field',
                'sendTo.routing' => 'required_if:sendTo.type,routing',
                'subject'      => 'required',
                'message'      => 'required',
            ],
            [
                'sendTo.type.required'            => 'The Send To field is required.',
                'sendTo.email.required_if'        => 'The Send to Email field is required.',
                'sendTo.field.required_if'        => 'The Send to Field field is required.',
                'sendTo.routing' => 'Please fill all the routing rules above.',
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
        $validator->sometimes('sendTo.routing', 'required', function ($input) {
            if (ArrayHelper::get($input, 'sendTo.type') !== 'routing') {
                return false;
            }

            $routingInputs = ArrayHelper::get($input, 'sendTo.routing');
            $required = false;

            foreach ($routingInputs as $routingInput) {
                if (!$routingInput['input_value'] || !$routingInput['field']) {
                    $required = true;
                    break;
                }
            }

            return $required;
        });

        return $validator;
    }
}
