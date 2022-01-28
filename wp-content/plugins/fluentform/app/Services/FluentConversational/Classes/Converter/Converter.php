<?php

namespace FluentForm\App\Services\FluentConversational\Classes\Converter;

use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\App\Modules\Component\Component;
use FluentForm\App\Services\FormBuilder\Components\DateTime;
use FluentForm\App\Services\FluentConversational\Classes\Form;

class Converter
{
	public static function convert($form)
	{
		$form->fields = json_decode($form->form_fields, true);

		$fields = $form->fields['fields'];

		$form->submit_button = $form->fields['submitButton'];

		$questions = [];

		$imagePreloads = [];

		$allowedFields = static::fieldTypes();
		// dd($fields);
		foreach ($fields as $field) {
			$question = [
				'id'                 => $field['uniqElKey'],
				'name'               => ArrayHelper::get($field, 'attributes.name'),
				'title'              => ArrayHelper::get($field, 'settings.label'),
				'type'               => ArrayHelper::get($allowedFields, $field['element']),
				'ff_input_type'      => $field['element'],
                'container_class'    => ArrayHelper::get($field, 'settings.container_class'),
                'placeholder'        => ArrayHelper::get($field, 'attributes.placeholder'),
				'required'           => ArrayHelper::get($field, 'settings.validation_rules.required.value'),
				'requiredMsg'        => ArrayHelper::get($field, 'settings.validation_rules.required.message'),
				'errorMessage'       => ArrayHelper::get($field, 'settings.validation_rules.required.message'),
				'validationRules'    => ArrayHelper::get($field, 'settings.validation_rules'),
				'tagline'            => ArrayHelper::get($field, 'settings.help_message'),
				'style_pref'         => ArrayHelper::get($field, 'style_pref', [
					'layout'           => 'default',
					'media'            => '',
					'brightness'       => 0,
					'alt_text'         => '',
					'media_x_position' => 50,
					'media_y_position' => 50
				]),
				'conditional_logics' => self::parseConditionalLogic($field)
			];

            if ($answer = self::setDefaultValue(ArrayHelper::get($field, 'attributes.value'), $field, $form)) {
                $question['answer'] = $answer;
            }

			if (ArrayHelper::get($question, 'style_pref.layout') != 'default') {
				$media = ArrayHelper::get($question, 'style_pref.media');
				if ($media) {
					$imagePreloads[] = $media;
				}
			}

			if ($field['element'] === 'input_text') {
				$mask = ArrayHelper::get($field, 'settings.temp_mask');

				$mask = $mask === 'custom' ? ArrayHelper::get($field, 'attributes.data-mask') : $mask;

				if ($mask) {
					$question['mask'] = $mask;
				}
			} elseif ($field['element'] === 'welcome_screen') {
				$question['settings'] = ArrayHelper::get($field, 'settings', []);
				$question['subtitle'] = ArrayHelper::get($field, 'settings.description');
				$question['required'] = false;
//				$question['css'] = (new \FluentConversational\Form)->getSubmitBttnStyle($field);

			} elseif ($field['element'] === 'select') {
				$question['options'] = self::getAdvancedOptions($field);
				$question['placeholder'] = ArrayHelper::get($field, 'settings.placeholder', null);
				$question['searchable'] = ArrayHelper::get($field, 'settings.enable_select_2');
				$isMultiple = ArrayHelper::get($field, 'attributes.multiple', false);

				if ($isMultiple) {
					$question['multiple'] = true;
					$question['placeholder'] = ArrayHelper::get($field, 'attributes.placeholder', false);
					$question['max_selection'] = ArrayHelper::get($field, 'settings.max_selection');
					$question['max_selection'] = $question['max_selection'] ? intval($question['max_selection']) : 0;
				}
			} elseif ($field['element'] === 'select_country') {
                $countryComponent =  new \FluentForm\App\Services\FormBuilder\Components\SelectCountry();
                $field = $countryComponent->loadCountries($field);
                $activeList = ArrayHelper::get($field, 'settings.country_list.active_list');
                if ($activeList == 'priority_based') {
                    $selectCountries = ArrayHelper::get($field, 'settings.country_list.priority_based', []);
                    $priorityCountries = $countryComponent->getSelectedCountries($selectCountries);
                    // @todo : add opt group in conversation js
                    $question['has_opt_grp'] = true;
                    $primaryListLabel = ArrayHelper::get($field, 'settings.primary_label');
                    $otherListLabel = ArrayHelper::get($field, 'settings.other_label');
                    $field['options'] = array_merge($priorityCountries, $field['options']);
                }

                $options = array();
				$countries = $field['options'];
				foreach ($countries as $key => $value) {
					$options[] = [
						'label' => $value,
						'value' => $key
					];
				}
				$question['options'] = $options;
				$question['placeholder'] = ArrayHelper::get($field, 'attributes.placeholder', null);
				$question['searchable'] = ArrayHelper::get($field, 'settings.enable_select_2');
			} elseif ($field['element'] === 'input_checkbox') {
				$question['options'] = self::getAdvancedOptions($field);;
				$question['multiple'] = true;
				$question = static::hasPictureMode($field, $question);
			} elseif ($field['element'] === 'input_radio') {
				$question['options'] = self::getAdvancedOptions($field);
				$question['nextStepOnAnswer'] = true;
				$question = static::hasPictureMode($field, $question);
			} elseif ($field['element'] === 'custom_html') {
				$question['content'] = ArrayHelper::get($field, 'settings.html_codes', '');
			} elseif ($field['element'] === 'section_break') {
				$question['content'] = ArrayHelper::get($field, 'settings.description', '');
				$question['contentAlign'] = ArrayHelper::get($field, 'settings.align', '');
			} elseif ($field['element'] === 'phone') {
				if (defined('FLUENTFORMPRO')) {
					$cssSource = FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/css/intlTelInput.min.css';
					if (is_rtl()) {
						$cssSource = FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/css/intlTelInput-rtl.min.css';
					}
					wp_enqueue_style('intlTelInput', $cssSource, [], '16.0.0');
					wp_enqueue_script('intlTelInputUtils', FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/js/utils.js', [], '16.0.0', true);
					wp_enqueue_script('intlTelInput', FLUENTFORMPRO_DIR_URL . 'public/libs/intl-tel-input/js/intlTelInput.min.js', [], '16.0.0', true);
					$question['phone_settings'] = self::getPhoneFieldSettings($field, $form);
				}
			} elseif ($field['element'] === 'input_number') {
				$question['min'] = ArrayHelper::get($field, 'settings.validation_rules.min.value');
				$question['max'] = ArrayHelper::get($field, 'settings.validation_rules.max.value');
				$question['min'] = is_numeric($question['min']) ? $question['min'] : null;
				$question['max'] = is_numeric($question['max']) ? $question['max'] : null;
			} elseif (in_array($field['element'], ['terms_and_condition', 'gdpr_agreement'])) {
				$question['options'] = [
					[
						'label' => ArrayHelper::get($field, 'settings.tc_agree_text', 'I accept'),
						'value' => 'on',
					],
					[
						'label' => ArrayHelper::get($field, 'settings.tc_dis_agree_text', 'I accept'),
						'value' => 'off',
					]
				];

				$question['nextStepOnAnswer'] = true;
				$question['title'] = ArrayHelper::get($field, 'settings.tnc_html');
				if ($field['element'] === 'gdpr_agreement') {
					$question['required'] = true;
				}

			} elseif ($field['element'] === 'ratings') {
				$question['show_text'] = ArrayHelper::get($field, 'settings.show_text');
				$question['rateOptions'] = ArrayHelper::get($field, 'options', []);
				$question['nextStepOnAnswer'] = true;
			} elseif ($field['element'] === 'input_date') {
				$app = wpFluentForm();
				$dateField = new DateTime();

				wp_enqueue_style('flatpickr', $app->publicUrl('libs/flatpickr/flatpickr.min.css'));
				wp_enqueue_script('flatpickr', $app->publicUrl('libs/flatpickr/flatpickr.js'), [], false, true);

				$question['dateConfig'] = json_decode($dateField->getDateFormatConfigJSON($field['settings'], $form));
				$question['dateCustomConfig'] = $dateField->getCustomConfig($field['settings']);
			} elseif (in_array($field['element'], ['input_image', 'input_file'])) {
                $question['multiple'] = true;

                $maxFileCount = ArrayHelper::get($field, 'settings.validation_rules.max_file_count');
                $maxFileSize = ArrayHelper::get($field, 'settings.validation_rules.max_file_size');

                if ($field['element'] === 'input_image') {
                    $allowedFieldTypes = ArrayHelper::get($field, 'settings.validation_rules.allowed_image_types.value');
                } else {
                    $allowedFieldTypes = ArrayHelper::get($field, 'settings.validation_rules.allowed_file_types.value');
                }

                if ($maxFileCount) {
                    $question['max'] = $maxFileCount['value'];
                }

                if ($maxFileSize) {
                    $question['maxSize'] = $maxFileSize['value'];
                }

                if ($allowedFieldTypes) {
                    $question['accept'] = implode('|', $allowedFieldTypes);
                }
            } elseif ($field['element'] === 'tabular_grid') {
                $question['grid_columns'] = $field['settings']['grid_columns'];
                $question['grid_rows'] = $field['settings']['grid_rows'];
                $question['selected_grids'] = $field['settings']['selected_grids'];
                $question['multiple'] = $field['settings']['tabular_field_type'] === 'checkbox';

                if ($field['settings']['selected_grids']) {
                    $rowValues = array_keys($question['grid_rows']);
                    $colValues = array_keys($question['grid_columns']);

                    foreach ($field['settings']['selected_grids'] as $selected) {
                        if (in_array($selected, $rowValues)) {
                            $question['answer'][$selected] = $colValues;
                        } else {
                            foreach ($rowValues as $rowValue) {
                                if ($question['multiple']) {
                                    $question['answer'][$rowValue][] = $selected;
                                } else {
                                    $question['answer'][$rowValue] = $selected;
                                }
                            }
                        }
                    }
                }

                $question['requiredPerRow'] = ArrayHelper::get($field, 'settings.validation_rules.required.per_row');
            } elseif ($field['element'] === 'multi_payment_component') {
				$type = $field['attributes']['type'];

				if ($type == 'single') {
					$question['priceLabel'] = $field['settings']['price_label'];
				} else {
					$question['nextStepOnAnswer'] = true;

					if ($type == 'radio' || $type == 'checkbox') {
						$question['paymentType'] = 'MultipleChoiceType';
						$question['type'] = 'FlowFormMultipleChoiceType';
						$question = static::hasPictureMode($field, $question);

						if ($type == 'checkbox') {
							$question['multiple'] = true;
						}
					} else {
						$question['paymentType'] = 'DropdownType';
						$question['type'] = 'FlowFormDropdownType';
					}

					$question['options'] = $field['settings']['pricing_options'];
				}

				$question['is_payment_field'] = true;
			} elseif ($field['element'] === 'subscription_payment_component') {
				$question['is_payment_field'] = true;
				$question['is_subscription_field'] = true;
				$question['answer'] = null;
				
				$type = $field['attributes']['type'];
				$question['subscriptionFieldType'] = $type;
				$currency = \FluentFormPro\Payments\PaymentHelper::getFormCurrency($form->id);

				foreach ($field['settings']['subscription_options'] as $index => &$option) {
					$hasCustomPayment = false;

					if (array_key_exists('user_input', $option) && $option['user_input'] == 'yes') {
						$hasCustomPayment = true;
						$option['subscription_amount'] = 0;

						if (array_key_exists('user_input_default_value', $option)) {
							$option['subscription_amount'] = $option['user_input_default_value'];
						}
					}
					
					$paymentSummaryText = \FluentFormPro\Payments\PaymentHelper::getPaymentSummaryText($option, $form->id, $currency, false);

					$planValue = $type == 'single' ? $option['subscription_amount'] : $index;

					$field['plans'][] = [
						'label' => $option['name'],
						'value' => $planValue,
						'sub'   => strip_tags($paymentSummaryText),
						'subscription_amount' => $planValue
					];

					$option['sub'] = strip_tags($paymentSummaryText);

					if ($option['is_default'] == 'yes') {
						$question['answer'] = $index;
					}

					if ($hasCustomPayment) {
						$option['customInput'] = $question['name'] . '_custom_' . $index;
						$question['customPayment'] = $option['subscription_amount'];
					}
				}

				$question['plans'] = $field['settings']['subscription_options'];

				if ($type != 'single') {
					$question['options'] = $field['plans'];
					$question['subscriptionFieldType'] = $field['settings']['selection_type'] == 'radio' ? 'FlowFormMultipleChoiceType' : 'FlowFormDropdownType';
					$question['nextStepOnAnswer'] = true;
				}
			} elseif ($field['element'] === 'custom_payment_component') {
				$question['type'] = 'FlowFormNumberType';
				$question['min'] = ArrayHelper::get($field, 'settings.validation_rules.min.value');
				$question['max'] = ArrayHelper::get($field, 'settings.validation_rules.max.value');
				$question['min'] = is_numeric($question['min']) ? $question['min'] : null;
				$question['max'] = is_numeric($question['max']) ? $question['max'] : null;

				$question['is_payment_field'] = true;
			} elseif ($field['element'] === 'item_quantity_component') {
				$question['type'] = $allowedFields['input_number'];
				$question['targetProduct'] = $field['settings']['target_product'];

				$question['min'] = ArrayHelper::get($field, 'settings.validation_rules.min.value');
				$question['max'] = ArrayHelper::get($field, 'settings.validation_rules.max.value');
				$question['min'] = is_numeric($question['min']) ? $question['min'] : null;
				$question['max'] = is_numeric($question['max']) ? $question['max'] : null;
				$question['step'] = 1;
				$question['stepErrorMsg'] = __('Please enter a valid value. The two nearest valid values are {lower_value} and {upper_value}', 'fluentform');
			} elseif ($field['element'] === 'payment_method') {
				$question['nextStepOnAnswer'] = true;
				$question['options'] = [];
				$question['paymentMethods'] = [];

				foreach ($field['settings']['payment_methods'] as $methodName => $paymentMethod) {
					if ($paymentMethod['enabled'] === 'yes') {
						$question['options'][] = [
							'label' => $paymentMethod['settings']['option_label']['value'],
							'value' => $paymentMethod['method_value']
						];

						$question['paymentMethods'][$methodName] = $paymentMethod;

						do_action(
							'fluentform_rendering_payment_method_' . $methodName,
							$paymentMethod,
							$field,
							$form
						);
					}
				}
			} elseif ($field['element'] === 'payment_summary_component') {
				$question['title'] = 'Payment Summary';
				$question['emptyText'] = $field['settings']['cart_empty_text'];
			}

			if ($question['type']) {
				$questions[] = $question;
			}
			if ($field['element'] === 'custom_submit_button') {
				$form->submit_button = $field;
			}
		}

		$form->questions = $questions;

		$form->image_preloads = $imagePreloads;

		return $form;
	}

	public static function fieldTypes()
	{
		$fieldTypes = [
			'input_url'             => 'FlowFormUrlType',
			'input_date'            => 'FlowFormDateType',
			'input_text'            => 'FlowFormTextType',
			'input_email'           => 'FlowFormEmailType',
			'input_hidden'          => 'FlowFormHiddenType',
			'input_number'          => 'FlowFormNumberType',
			'select'                => 'FlowFormDropdownType',
			'select_country'        => 'FlowFormDropdownType',
			'textarea'              => 'FlowFormLongTextType',
			'input_password'        => 'FlowFormPasswordType',
			'custom_html'           => 'FlowFormSectionBreakType',
			'section_break'         => 'FlowFormSectionBreakType',
			'welcome_screen'        => 'FlowFormWelcomeScreenType',
			'input_checkbox'        => 'FlowFormMultipleChoiceType',
			'input_radio'           => 'FlowFormMultipleChoiceType',
			'terms_and_condition'   => 'FlowFormTermsAndConditionType',
            'gdpr_agreement'        => 'FlowFormTermsAndConditionType',
            'MultiplePictureChoice' => 'FlowFormMultiplePictureChoiceType',
		];

		if (defined('FLUENTFORMPRO')) {
			$fieldTypes['phone'] = 'FlowFormPhoneType';
			$fieldTypes['input_image'] = 'FlowFormFileType';
			$fieldTypes['input_file'] = 'FlowFormFileType';
			$fieldTypes['ratings'] = 'FlowFormRateType';
			$fieldTypes['tabular_grid'] = 'FlowFormMatrixType';
			$fieldTypes['payment_method'] = 'FlowFormPaymentMethodType';
			$fieldTypes['multi_payment_component'] = 'FlowFormPaymentType';
			$fieldTypes['custom_payment_component'] = 'FlowFormPaymentType';
			$fieldTypes['payment_summary_component'] = 'FlowFormPaymentSummaryType';
			$fieldTypes['subscription_payment_component'] = 'FlowFormSubscriptionType';
			$fieldTypes['payment_coupon'] = 'FlowFormCouponType';
		}

		return $fieldTypes;
	}

	public static function hasPictureMode($field, $question)
	{
		$pictureMode = ArrayHelper::get($field, 'settings.enable_image_input');

		if ($pictureMode) {
			$question['type'] = static::fieldTypes()['MultiplePictureChoice'];
		}

		return $question;
	}

	public static function hex2rgb($color, $opacity = 0.3)
	{
		if (!$color) {
			return;
		}
		$rgbValues = list($r, $g, $b) = array_map(
			function ($c) {
				return hexdec(str_pad($c, 2, $c));
			},
			str_split(ltrim($color, '#'), strlen($color) > 4 ? 2 : 1)
		);
		$rgbValues[3] = $opacity;
		$formattedValues = implode(',', $rgbValues);
		return "rgb({$formattedValues})";
	}

	public static function getPhoneFieldSettings($data, $form)
	{
		$geoLocate = ArrayHelper::get($data, 'settings.auto_select_country') == 'yes';
		$enabled = ArrayHelper::get($data, 'settings.int_tel_number') == 'with_extended_validation';

		$itlOptions = [
			'separateDialCode' => false,
			'nationalMode'     => true,
			'autoPlaceholder'  => 'aggressive',
			'formatOnDisplay'  => true
		];

		if ($geoLocate) {
			$itlOptions['initialCountry'] = 'auto';
		} else {
			$itlOptions['initialCountry'] = ArrayHelper::get($data, 'settings.default_country', '');
			$activeList = ArrayHelper::get($data, 'settings.phone_country_list.active_list');

			if ($activeList == 'priority_based') {
				$selectCountries = ArrayHelper::get($data, 'settings.phone_country_list.priority_based', []);
				$priorityCountries = self::getSelectedCountries($selectCountries);
				$itlOptions['preferredCountries'] = array_keys($priorityCountries);
			} else if ($activeList == 'visible_list') {
				$onlyCountries = ArrayHelper::get($data, 'settings.phone_country_list.visible_list', []);
				$itlOptions['onlyCountries'] = $onlyCountries;
			} else if ($activeList == 'hidden_list') {
				$countries = self::loadCountries($data);
				$itlOptions['onlyCountries'] = array_keys($countries);
			}
		}

		$itlOptions = apply_filters('fluentform_itl_options', $itlOptions, $data, $form);
		$itlOptions = json_encode($itlOptions);

		$settings = get_option('_fluentform_global_form_settings');
		$token = ArrayHelper::get($settings, 'misc.geo_provider_token');

		$url = 'https://ipinfo.io';
		if ($token) {
			$url = 'https://ipinfo.io/?token=' . $token;
		}
		$ipProviderUrl = apply_filters('fluentform_ip_provider', $url);

		return [
			'enabled'     => $enabled,
			'itlOptions'  => $itlOptions,
			'ipLookupUrl' => ($geoLocate && $ipProviderUrl) ? $ipProviderUrl : false,
		];
	}

	/**
	 * Load country list from file
	 * @param array $data
	 * @return array
	 */
	public static function loadCountries($data)
	{
		$data['options'] = array();
		$activeList = ArrayHelper::get($data, 'settings.phone_country_list.active_list');
		$countries = getFluentFormCountryList();
		$filteredCountries = [];
		if ($activeList == 'visible_list') {
			$selectCountries = ArrayHelper::get($data, 'settings.phone_country_list.' . $activeList, []);
			foreach ($selectCountries as $value) {
				$filteredCountries[$value] = $countries[$value];
			}
		} elseif ($activeList == 'hidden_list' || $activeList == 'priority_based') {
			$filteredCountries = $countries;
			$selectCountries = ArrayHelper::get($data, 'settings.phone_country_list.' . $activeList, []);
			foreach ($selectCountries as $value) {
				unset($filteredCountries[$value]);
			}
		} else {
			$filteredCountries = $countries;
		}

		return $filteredCountries;
	}

	public static function getSelectedCountries($keys = [])
	{
		$options = [];
		$countries = getFluentFormCountryList();
		foreach ($keys as $value) {
			$options[$value] = $countries[$value];
		}

		return $options;
	}

	public static function setDefaultValue($value, $field, $form)
	{
		if ($dynamicValue = ArrayHelper::get($field, 'settings.dynamic_default_value')) {
			$dynamicVal = (new Component(wpFluentForm()))->replaceEditorSmartCodes($dynamicValue, $form);

			$element = $field['element'];

			if ($dynamicVal && $element == 'input_checkbox') {
				$defaultValues = explode(',', $dynamicVal);
				return array_map('trim', $defaultValues);
			}

			if ($dynamicVal) {
				return $dynamicVal;
			}
		}

		if (!$value) {
			return $value;
		}
		if (is_string($value)) {
			return (new Component(wpFluentForm()))->replaceEditorSmartCodes($value, $form);
		}

		return $value;
	}

	private static function parseConditionalLogic($field)
	{
		$logics = ArrayHelper::get($field, 'settings.conditional_logics', []);

		if (!$logics || !$logics['status']) {
			return [];
		}

		$validConditions = [];
		foreach ($logics['conditions'] as $condition) {
			if (empty($condition['field']) || empty($condition['operator'])) {
				continue;
			}
			$validConditions[] = $condition;
		}

		if (!$validConditions) {
			return [];
		}

		$logics['conditions'] = $validConditions;

		return $logics;
	}

	private static function getAdvancedOptions($field)
	{
		$options = ArrayHelper::get($field, 'settings.advanced_options', []);

		if ($options && ArrayHelper::get($field, 'settings.randomize_options') == 'yes') {
			shuffle($options);
		}

		return $options;

	}
}
