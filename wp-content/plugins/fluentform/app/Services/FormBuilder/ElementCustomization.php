<?php

/**
 * element_customization_settings
 *
 * Returns an array of countries and codes.
 *
 * @author      WooThemes
 * @category    i18n
 * @package     fluentform/i18n
 * @version     2.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$dateFormats = (new \FluentForm\App\Services\FormBuilder\Components\DateTime)->getAvailableDateFormats();

$dateConfigSettings = array(
    'template' => 'inputTextarea',
    'label' => __('Advanced Date Configuration', 'fluentform'),
    'placeholder' => __('Advanced Date Configuration', 'fluentform'),
    'rows' => (defined('FLUENTFORMPRO')) ? 10 : 2,
    'start_text' => (defined('FLUENTFORMPRO')) ? 10 : 2,
    'disabled' => !defined('FLUENTFORMPRO'),
    'css_class' => 'ff_code_editor',
    'inline_help_text' => 'Only valid JS object will work. Please check <a target="_blank" href="https://wpmanageninja.com/docs/fluent-form/field-types/time-date#advanced_configaration">the documentation for available config options</a>',
    'help_text' => __('You can write your own date configuration as JS object. Please write valid configuration as per flatpickr config.', 'fluentform'),
);

if (!defined('FLUENTFORMPRO')) {
    $dateConfigSettings['inline_help_text'] = 'Available on Fluent Forms Pro';
}


$element_customization_settings = array(
    'name' => array(
        'template' => 'nameAttr',
        'label' => __('Name Attribute', 'fluentform'),
        'help_text' => __('This is the field name attributes which is used to submit form data, name attribute must be unique.', 'fluentform'),
    ),
    'label' => array(
        'template' => 'inputText',
        'label' => __('Element Label', 'fluentform'),
        'help_text' => __('This is the field title the user will see when filling out the form.', 'fluentform'),
    ),
    'label_placement' => array(
        'template' => 'radioButton',
        'label' => __('Label Placement', 'fluentform'),
        'help_text' => __('Determine the position of label title where the user will see this. By choosing "Default", global label placement setting will be applied.', 'fluentform'),
        'options' => array(
            array(
                'value' => '',
                'label' => __('Default', 'fluentform'),
            ),
            array(
                'value' => 'top',
                'label' => __('Top', 'fluentform'),
            ),
            array(
                'value' => 'right',
                'label' => __('Right', 'fluentform'),
            ),
            array(
                'value' => 'bottom',
                'label' => __('Bottom', 'fluentform'),
            ),
            array(
                'value' => 'left',
                'label' => __('Left', 'fluentform'),
            ),
            array(
                'value' => 'hide_label',
                'label' => __('Hide Label', 'fluentform'),
            ),
        ),
    ),
    'button_style' => array(
        'template' => 'selectBtnStyle',
        'label' => __('Button Style', 'fluentform'),
        'help_text' => __('Select a button style from the dropdown', 'fluentform'),
    ),
    'button_size' => array(
        'template' => 'radioButton',
        'label' => __('Button Size', 'fluentform'),
        'help_text' => __('Define a size of the button', 'fluentform'),
        'options' => array(
            array(
                'value' => 'sm',
                'label' => __('Small', 'fluentform'),
            ),
            array(
                'value' => 'md',
                'label' => __('Medium', 'fluentform'),
            ),
            array(
                'value' => 'lg',
                'label' => __('Large', 'fluentform'),
            ),
        )
    ),
    'placeholder' => array(
        'template' => 'inputText',
        'label' => __('Placeholder', 'fluentform'),
        'help_text' => __('This is the field placeholder, the user will see this if the input field is empty.', 'fluentform'),
    ),
    'date_format' => array(
        'template' => 'select',
        'label' => __('Date Format', 'fluentform'),
        'filterable' => true,
        'creatable' => true,
        'placeholder' => __('Select Date Format', 'fluentform'),
        'help_text' => __('Select any date format from the dropdown. The user will be able to choose a date in this given format.', 'fluentform'),
        'options' => $dateFormats,
    ),
    'date_config' => $dateConfigSettings,
    'rows' => array(
        'template' => 'inputText',
        'label' => __('Rows', 'fluentform'),
        'help_text' => __('How many rows will textarea take in a form. It\'s an HTML attributes for browser support.', 'fluentform'),
    ),
    'cols' => array(
        'template' => 'inputText',
        'label' => __('Columns', 'fluentform'),
        'help_text' => __('How many cols will textarea take in a form. It\'s an HTML attributes for browser support.', 'fluentform'),
    ),
    'options' => array(
        'template' => 'selectOptions',
        'label' => __('Options', 'fluentform'),
        'help_text' => __('Create options for the field and checkmark them for default selection.', 'fluentform'),
    ),
    'advanced_options' => array(
        'template' => 'advancedOptions',
        'label' => __('Options', 'fluentform'),
        'help_text' => __('Create visual options for the field and checkmark them for default selection.', 'fluentform'),
    ),
    'enable_select_2' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Enable Searchable Smart Options', 'fluentform'),
        'help_text' => __('If you enable this then options will be searchable by select2 js library', 'fluentform'),
    ),
    'pricing_options' => array(
        'template' => 'pricingOptions',
        'label' => __('Payment Items', 'fluentform'),
        'help_text' => __('Set your product type and corresponding prices', 'fluentform'),
    ),
    'subscription_options' => array(
	    'template' => 'subscriptionOptions',
	    'label' => __('Subscription Items', 'fluentform'),
	    'help_text' => __('Set your subscription plans', 'fluentform'),
    ),
    'validation_rules' => array(
        'template' => 'validationRulesForm',
        'label' => __('Validation Rules', 'fluentform'),
        'help_text' => '',
    ),
    'required_field_message' => array(
        'template' => 'inputRequiredFieldText',
        'label' => __('Required Validation Message', 'fluentform'),
        'help_text' => 'Message for failed validation for this field',
    ),
    'tnc_html' => array(
        'template' => 'inputHTML',
        'label' => __('Terms & Conditions', 'fluentform'),
        'help_text' => __('Write HTML content for terms & condition checkbox', 'fluentform'),
        'rows' => 4,
        'cols' => 2,
    ),
    'hook_name' => array(
        'template' => 'customHookName',
        'label' => __('Hook Name', 'fluentform'),
        'help_text' => __('WordPress Hook name to hook something in this place.', 'fluentform'),
    ),
    'has_checkbox' => array(
        'template' => 'inputCheckbox',
        'options' => array(
            array(
                'value' => true,
                'label' => __('Show Checkbox', 'fluentform'),
            ),
        ),
    ),
    'html_codes' => array(
        'template' => 'inputHTML',
        'rows' => 4,
        'cols' => 2,
        'label' => __('HTML Code', 'fluentform'),
        'help_text' => __('Your valid HTML code will be shown to the user as normal content.', 'fluentform'),
    ),
    'description' => array(
        'template' => 'inputHTML',
        'rows' => 4,
        'cols' => 2,
        'label' => __('Description', 'fluentform'),
        'help_text' => __('Description will be shown to the user as normal text content.', 'fluentform'),
    ),
    'btn_text' => array(
        'template' => 'inputText',
        'label' => __('Button Text', 'fluentform'),
        'help_text' => __('This will be visible as button text for upload file.', 'fluentform'),
    ),
    'button_ui' => array(
        'template' => 'prevNextButton',
        'label' => __('Submit Button', 'fluentform'),
        'help_text' => __('This is form submission button.', 'fluentform'),
    ),
    'align' => array(
        'template' => 'radio',
        'label' => __('Content Alignment', 'fluentform'),
        'help_text' => __('How the content will be aligned.', 'fluentform'),
        'options' => array(
            array(
                'value' => 'left',
                'label' => __('Left', 'fluentform'),
            ),
            array(
                'value' => 'center',
                'label' => __('Center', 'fluentform'),
            ),
            array(
                'value' => 'right',
                'label' => __('Right', 'fluentform'),
            ),
        ),
    ),
    'shortcode' => array(
        'template' => 'inputText',
        'label' => __('Shortcode', 'fluentform'),
        'help_text' => __('Your shortcode to render desired content in current place.', 'fluentform'),
    ),
    'apply_styles' => array(
        'template' => 'radioButton',
        'label' => __('Apply Styles', 'fluentform'),
        'help_text' => __('Apply styles provided here', 'fluentform'),
        'options' => array(
            array(
                'value' => true,
                'label' => __('Yes', 'fluentform'),
            ),
            array(
                'value' => false,
                'label' => __('No', 'fluentform'),
            )
        ),
    ),
    'step_title' => array(
        'template' => 'inputText',
        'label' => __('Step Title', 'fluentform'),
        'help_text' => __('Form step titles, user will see each title in each step.', 'fluentform'),
    ),
    'disable_auto_focus' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Disable auto focus when changing each page', 'fluentform'),
        'help_text' => __('If you enable this then on page transition automatic scrolling will be disabled', 'fluentform'),
    ),
    'enable_auto_slider' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Enable auto page change for single radio field', 'fluentform'),
        'help_text' => __('If you enable this then for last radio item field will trigger next page change', 'fluentform'),
    ),
    'enable_step_data_persistency' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Enable Per step data save (Save and Continue)', 'fluentform'),
        'help_text' => __('If you enable this then on each step change the data current step data will be persisted in a step form<br />Your users can resume the form where they left', 'fluentform'),
    ),
    'enable_step_page_resume' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Resume Step from last form session', 'fluentform'),
        'help_text' => __('If you enable this then users will see the form as step page where it has been left', 'fluentform'),
        'dependency' => array(
            'depends_on' => 'settings/enable_step_data_persistency',
            'value' => 'yes',
            'operator' => '=='
        )
    ),
    'progress_indicator' => array(
        'template' => 'radio',
        'label' => __('Progress Indicator', 'fluentform'),
        'help_text' => __('Select any of them below, user will see progress of form steps according to your choice.', 'fluentform'),
        'options' => array(
            array(
                'value' => 'progress-bar',
                'label' => __('Progress Bar', 'fluentform'),
            ),
            array(
                'value' => 'steps',
                'label' => __('Steps', 'fluentform'),
            ),
            array(
                'value' => '',
                'label' => __('None', 'fluentform'),
            ),
        ),
    ),
    'step_titles' => array(
        'template' => 'customStepTitles',
        'label' => __('Step Titles', 'fluentform'),
        'help_text' => __('Form step titles, user will see each title in each step.', 'fluentform'),
    ),
    'prev_btn' => array(
        'template' => 'prevNextButton',
        'label' => __('Previous Button', 'fluentform'),
        'help_text' => __('Multi-step form\'s previous button', 'fluentform'),
    ),
    'next_btn' => array(
        'template' => 'prevNextButton',
        'label' => __('Next Button', 'fluentform'),
        'help_text' => __('Multi-step form\'s next button', 'fluentform'),
    ),
    'address_fields' => array(
        'template' => 'addressFields',
        'label' => __('Address Fields', 'fluentform'),
    ),
    'name_fields' => array(
        'template' => 'nameFields',
        'label' => __('Name Fields', 'fluentform'),
    ),
    'multi_column' => array(
        'template' => 'inputCheckbox',
        'options' => array(
            array(
                'value' => true,
                'label' => __('Enable Multiple Columns', 'fluentform'),
            ),
        ),
    ),
    'repeat_fields' => array(
        'template' => 'customRepeatFields',
        'label' => __('Repeat Fields', 'fluentform'),
        'help_text' => __('This is a form field which a user will be able to repeat.', 'fluentform'),
    ),
    'admin_field_label' => array(
        'template' => 'inputText',
        'label' => __('Admin Field Label', 'fluentform'),
        'help_text' => __('Admin field label is field title which will be used for admin field title.', 'fluentform'),
    ),
    'maxlength' => array(
        'template' => 'inputNumber',
        'label' => __('Max text length', 'fluentform'),
        'help_text' => __('The maximum number of characters the input should accept', 'fluentform'),
    ),
    'value' => array(
        'template' => 'inputValue',
        'label' => __('Default Value', 'fluentform'),
        'help_text' => __('If you would like to pre-populate the value of a field, enter it here.', 'fluentform'),
    ),
    'dynamic_default_value' => array(
        'template' => 'inputValue',
        'type' => 'text',
        'label' => __('Dynamic Default Value', 'fluentform'),
        'help_text' => __('If you would like to pre-populate the value of a field, enter it here.', 'fluentform'),
    ),
    'max_selection' => array(
        'template' => 'inputNumber',
        'type' => 'text',
        'label' => __('Max Selection', 'fluentform'),
        'help_text' => __('Define Max selections items that a user can select .', 'fluentform'),
        'dependency' => array(
            'depends_on' => 'attributes/multiple',
            'value' => true,
            'operator' => '=='
        )
    ),
    'container_class' => array(
        'template' => 'inputText',
        'label' => __('Container Class', 'fluentform'),
        'help_text' => __('Class for the field wrapper. This can be used to style current element.', 'fluentform'),
    ),
    'class' => array(
        'template' => 'inputText',
        'label' => __('Element Class', 'fluentform'),
        'help_text' => __('Class for the field. This can be used to style current element.', 'fluentform'),
    ),
    'country_list' => array(
        'template' => 'customCountryList',
        'label' => __('Country List', 'fluentform'),
        'key' => 'country_list'
    ),
    'product_field_types' => array(
        'template' => 'productFieldTypes',
        'label' => __('Options', 'fluentform'),
    ),
    'help_message' => array(
        'template' => 'inputTextarea',
        'label' => __('Help Message', 'fluentform'),
        'help_text' => __('Help message will be shown as tooltip next to sidebar or below the field.', 'fluentform'),
    ),
    'conditional_logics' => array(
        'template' => 'conditionalLogics',
        'label' => __('Conditional Logic', 'fluentform'),
        'help_text' => __('Create rules to dynamically display or hide this field based on values from another field.', 'fluentform'),
    ),
    'background_color' => array(
        'template' => 'inputColor',
        'label' => __('Background Color', 'fluentform'),
        'help_text' => __('The Background color of the element', 'fluentform')
    ),
    'color' => array(
        'template' => 'inputColor',
        'label' => __('Font Color', 'fluentform'),
        'help_text' => __('Font color of the element', 'fluentform')
    ),
    'data-mask' => array(
        'template' => 'customMask',
        'label' => __('Custom Mask', 'fluentform'),
        'help_text' => __('Write your own mask for this input', 'fluentform'),
        'dependency' => array(
            'depends_on' => 'settings/temp_mask',
            'value' => 'custom',
            'operator' => '=='
        )
    ),
    'data-mask-reverse' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Activating a reversible mask', 'fluentform'),
        'help_text' => __('If you enable this then it the mask will work as reverse', 'fluentform'),
        'dependency' => array(
            'depends_on' => 'settings/temp_mask',
            'value' => 'custom',
            'operator' => '=='
        )
    ),
    'randomize_options' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Shuffle the available options', 'fluentform'),
        'help_text' => __('If you enable this then the checkable options will be shuffled', 'fluentform')
    ),
    'data-clear-if-not-match' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Clear if not match', 'fluentform'),
        'help_text' => __('Clear value if not match the mask', 'fluentform'),
        'dependency' => array(
            'depends_on' => 'settings/temp_mask',
            'value' => 'custom',
            'operator' => '=='
        )
    ),
    'temp_mask' => array(
        'template' => 'select',
        'label' => __('Mask Input', 'fluentform'),
        'help_text' => __('Select a mask for the input field', 'fluentform'),
        'options' => array(
            array(
                'value' => '',
                'label' => __('None', 'fluentform'),
            ),
            array(
                'value' => '(000) 000-0000',
                'label' => '(###) ###-####',
            ),
            array(
                'value' => '(00) 0000-0000',
                'label' => '(##) ####-####',
            ),
            array(
                'value' => '00/00/0000',
                'label' => __('23/03/2018', 'fluentform'),
            ),
            array(
                'value' => '00:00:00',
                'label' => __('23:59:59', 'fluentform'),
            ),
            array(
                'value' => '00/00/0000 00:00:00',
                'label' => __('23/03/2018 23:59:59', 'fluentform'),
            ),
            array(
                'value' => 'custom',
                'label' => __('Custom', 'fluentform'),
            )
        ),
    ),
    'grid_columns' => array(
        'template' => 'gridRowCols',
        'label' => __('Grid Columns', 'fluentform'),
        'help_text' => __('Write your own mask for this input', 'fluentform'),
    ),
    'grid_rows' => array(
        'template' => 'gridRowCols',
        'label' => __('Grid Rows', 'fluentform'),
        'help_text' => __('Write your own mask for this input', 'fluentform'),
    ),
    'tabular_field_type' => array(
        'template' => 'radio',
        'label' => __('Field Type', 'fluentform'),
        'help_text' => __('Field Type', 'fluentform'),
        'options' => array(
            array(
                'value' => 'checkbox',
                'label' => __('Checkbox', 'fluentform'),
            ),
            array(
                'value' => 'radio',
                'label' => __('Radio', 'fluentform'),
            ),
        )
    ),
    'max_repeat_field' => array(
        'template' => 'inputNumber',
        'label' => __('Max Repeat inputs', 'fluentform'),
        'help_text' => __('Please provide max number of rows the user can fill up for this repeat field. Keep blank/0 for unlimited numbers', 'fluentform')
    ),
    'calculation_settings' => array(
        'template' => (defined('FLUENTFORMPRO')) ? 'inputCalculationSettings' : 'infoBlock',
        'text' => '<b>Calculation Field Settings</b><br />Calculate the value based on other numeric field is available on pro version of WP Fluent Forms. Please install WP Fluent Forms Pro to use this feature',
        'label' => 'Calculation Field Settings',
        'status_label' => 'Enable Calculation',
        'formula_label' => 'Calculation Expression',
        'formula_tips' => 'You can use + - * / for calculating the the value. Use context icon to insert the input values',
        'status_tips' => 'Enable this and provide formula expression if you want this field as calculated based on other numeric field value'
    ),
    'min' => array(
        'template' => 'inputNumber',
        'label' => __('Min Value', 'fluentform'),
        'help_text' => __('Please provide minimum value', 'fluentform')
    ),
    'max' => array(
        'template' => 'inputNumber',
        'label' => __('Max Value', 'fluentform'),
        'help_text' => __('Please provide Maximum value', 'fluentform')
    ),
    'number_step' => array(
        'template' => 'inputText',
        'label' => __('Step', 'fluentform'),
        'help_text' => __('Please provide step attribute for this field. Give value "any" for floating value', 'fluentform')
    ),
    'prefix_label' => array(
        'template' => 'inputText',
        'label' => __('Prefix Label', 'fluentform'),
        'help_text' => __('Provide Input Prefix Label. It will show in the input field as prefix label', 'fluentform')
    ),
    'suffix_label' => array(
        'template' => 'inputText',
        'label' => __('Suffix Label', 'fluentform'),
        'help_text' => __('Provide Input Suffix Label. It will show in the input field as suffix label', 'fluentform')
    ),
    'is_unique' => array(
        'template' => 'inputYesNoCheckBox',
        'label' => __('Validate as Unique', 'fluentform'),
        'help_text' => __('If you make it unique then it will validate as unique from previous submissions of this form', 'fluentform')
    ),
    'show_text' => array(
        'template' => 'select',
        'label' => __('Show Text', 'fluentform'),
        'help_text' => __('Show Text value on selection', 'fluentform'),
        'options' => array(
            array(
                'value' => 'yes',
                'label' => __('Yes', 'fluentform'),
            ),
            array(
                'value' => 'no',
                'label' => __('No', 'fluentform'),
            )
        )
    ),
    'numeric_formatter' => array(
        'template' => 'select',
        'label' => __('Number Format', 'fluentform'),
        'help_text' => __('Select the format of numbers that are allowed in this field. You have the option to use a comma or a dot as the decimal separator.', 'fluentform'),
        'options' => \FluentForm\App\Helpers\Helper::getNumericFormatters()
    ),
    'unique_validation_message' => array(
        'template' => 'inputText',
        'label' => __('Validation Message for Duplicate', 'fluentform'),
        'help_text' => __('If validation failed then it will show this message', 'fluentform'),
        'dependency' => array(
            'depends_on' => 'settings/is_unique',
            'value' => 'yes',
            'operator' => '=='
        )
    ),
    'layout_class' => array(
        'template' => 'select',
        'label' => __('Layout', 'fluentform'),
        'help_text' => __('Select the Layout for checkable items', 'fluentform'),
        'options' => array(
            array(
                'value' => '',
                'label' => __('Default', 'fluentform'),
            ),
            array(
                'value' => 'ff_list_inline',
                'label' => 'Inline Layout',
            ),
            array(
                'value' => 'ff_list_buttons',
                'label' => 'Button Type Styles',
            ),
            array(
                'value' => 'ff_list_2col',
                'label' => '2-Column Layout',
            ),
            array(
                'value' => 'ff_list_3col',
                'label' => '3-Column Layout',
            ),
            array(
                'value' => 'ff_list_4col',
                'label' => '4-Column Layout',
            ),
            array(
                'value' => 'ff_list_5col',
                'label' => '5-Column Layout',
            )
        ),
    ),
);


return apply_filters('fluent_editor_element_customization_settings', $element_customization_settings);
