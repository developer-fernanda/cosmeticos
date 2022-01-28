<?php

/**
 * element_settings_placement
 *
 * Returns an array of countries and codes.
 *
 * @author      WooThemes
 * @category    i18n
 * @package     fluentform/i18n
 * @version     2.5.0
 */

return array(
    'input_name' => array(
        'general' => array(
            'admin_field_label',
            'name_fields',
            'label_placement',
        ),
        'advanced' => array(
            'container_class',
            'name',
            'conditional_logics',
        ),
    ),
    'input_email' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'validation_rules',
        ),
        'advanced' => array(
            'value',
            'container_class',
            'class',
            'help_message',
            'is_unique',
            'unique_validation_message',
            'prefix_label',
            'suffix_label',
            'name',
            'conditional_logics',
        ),
    ),
    'input_text' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'temp_mask',
            'data-mask',
            'data-mask-reverse',
            'data-clear-if-not-match',
            'validation_rules',
        ),
        'advanced' => array(
            'value',
            'container_class',
            'class',
            'help_message',
            'prefix_label',
            'suffix_label',
            'name',
            'maxlength',
            'is_unique',
            'unique_validation_message',
            'conditional_logics',
        ),
        'generalExtras' => array(),
        'advancedExtras' => array(),
    ),
    'textarea' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'rows',
            'cols',
            'validation_rules',
        ),
        'advanced' => array(
            'value',
            'container_class',
            'class',
            'help_message',
            'name',
            'maxlength',
            'conditional_logics',
        )
    ),
    'address' => array(
        'general' => array(
            'label',
            'admin_field_label',
            'address_fields',
        ),
        'advanced' => array(
            'class',
            'name',
            'conditional_logics',
        ),
    ),
    'select_country' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'enable_select_2',
            'placeholder',
            'validation_rules',
        ),
        'advanced' => array(
            'container_class',
            'class',
            'country_list',
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'input_number' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'validation_rules',
            'numeric_formatter'
        ),
        'advanced' => array(
            'value',
            'container_class',
            'class',
            'help_message',
            'number_step',
            'prefix_label',
            'suffix_label',
            'name',
            'conditional_logics',
            'calculation_settings'
        ),
    ),
    'select' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'advanced_options',
            'randomize_options',
            'enable_select_2',
            'max_selection',
            'validation_rules',
        ),
        'advanced' => array(
            'dynamic_default_value',
            'container_class',
            'class',
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'input_radio' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'advanced_options',
            'randomize_options',
            'validation_rules',
        ),
        'advanced' => array(
            'dynamic_default_value',
            'container_class',
            'help_message',
            'name',
            'layout_class',
            'conditional_logics',
        ),
    ),
    'input_checkbox' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'advanced_options',
            'randomize_options',
            'validation_rules',
        ),
        'advanced' => array(
            'dynamic_default_value',
            'container_class',
            'help_message',
            'name',
            'layout_class',
            'conditional_logics',
        ),
    ),
    'input_url' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'validation_rules',
        ),
        'advanced' => array(
            'value',
            'container_class',
            'class',
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'input_password' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'validation_rules',
        ),
        'advanced' => array(
            'value',
            'container_class',
            'class',
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'input_date' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'placeholder',
            'date_format',
            'validation_rules',
        ),
        'advanced' => array(
            'value',
            'container_class',
            'class',
            'help_message',
            'name',
            'date_config',
            'conditional_logics',
        ),
    ),
    'input_file' => array(
        'general' => array(
            'label',
            'btn_text',
            'label_placement',
            'admin_field_label',
            'validation_rules',
        ),
        'advanced' => array(
            'container_class',
            'class',
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'input_image' => array(
        'general' => array(
            'label',
            'btn_text',
            'label_placement',
            'admin_field_label',
            'validation_rules',
        ),
        'advanced' => array(
            'container_class',
            'class',
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'input_repeat' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'multi_column',
            'repeat_fields',
        ),
        'advanced' => array(
            'container_class',
            'name',
            'conditional_logics',
            'max_repeat_field'
        ),
    ),
    'input_hidden' => array(
        'general' => array(
            'admin_field_label',
            'value',
            'name',
        ),
    ),
    'section_break' => array(
        'general' => array(
            'label',
            'description',
            'align',
        ),
        'advanced' => array(
            'class',
            'conditional_logics',
        ),
    ),
    'recaptcha' => array(
        'general' => array(
            'label',
            'label_placement',
            'name',
            'validation_rules',
        ),
    ),
    'hcaptcha' => array(
        'general' => array(
            'label',
            'label_placement',
            'name',
            'validation_rules',
        ),
    ),
    'custom_html' => array(
        'general' => array(
            'html_codes',
            'conditional_logics',
            'container_class'
        ),
    ),
    'shortcode' => array(
        'general' => array(
            'shortcode',
        ),
        'generalExtras' => array(
            'message' => array(
                'template' => 'infoBlock',
                'text' => 'Hello',
            ),
        ),
        'advanced' => array(
            'class',
            'conditional_logics',
        ),
    ),
    'terms_and_condition' => array(
        'general' => array(
            'admin_field_label',
            'validation_rules',
            'tnc_html',
            'has_checkbox',
        ),
        'advanced' => array(
            'container_class',
            'class',
            'name',
            'conditional_logics',
        ),
    ),
    'action_hook' => array(
        'general' => array(
            'hook_name',
        ),
        'advanced' => array(
            'class',
            'conditional_logics',
        ),
    ),
    'form_step' => array(
        'general' => array(
            'prev_btn',
            'next_btn',
            'class',
        ),
    ),
    'button' => array(
        'general' => array(
            'btn_text',
            'button_ui',
            'button_style',
            'button_size',
            'align',
        ),
        'advanced' => array(
            'container_class',
            'class',
            'help_message',
            'conditional_logics',
        ),
        'generalExtras' => array(
            'btn_text' => array(
                'template' => 'inputText',
                'label' => __('Button Text', 'fluentform'),
                'help_text' => __('Form submission button text.', 'fluentform'),
            )
        )
    ),
    'step_start' => array(
        'general' => array(
            'class',
            'progress_indicator',
            'step_titles',
            'disable_auto_focus',
            'enable_auto_slider',
            'enable_step_data_persistency',
            'enable_step_page_resume'
        ),
    ),
    'step_end' => array(
        'general' => array(
            'class',
            'prev_btn',
        ),
    ),
    'ratings' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'options',
            'show_text',
            'validation_rules'
        ),
        'advanced' => array(
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'tabular_grid' => array(
        'general' => array(
            'label',
            'label_placement',
            'admin_field_label',
            'tabular_field_type',
            'grid_columns',
            'grid_rows',
            'validation_rules',
        ),
        'advanced' => array(
            'container_class',
            'help_message',
            'name',
            'conditional_logics',
        ),
    ),
    'gdpr_agreement' => array(
        'general' => array(
            'admin_field_label',
            'tnc_html',
            'required_field_message',
            'container_class'
        ),
        'advanced' => array(
            'class',
            'name',
            'conditional_logics',
        ),
        'generalExtras' => array(
            'tnc_html' => array(
                'template' => 'inputTextarea',
                'label' => __('Description', 'fluentform'),
                'help_text' => __('Write HTML content for GDPR agreement checkbox', 'fluentform'),
                'rows' => 5,
                'cols' => 3,
            )
        ),
    ),
    'container' => array(
        'general' => array(
            'container_class',
            'conditional_logics'
        ),
        'advanced' => []
    )
);

