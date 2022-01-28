<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;

class Select extends BaseComponent
{
    /**
     * Compile and echo the html element
     * @param array $data [element data]
     * @param stdClass $form [Form Object]
     * @return viod
     */
    public function compile($data, $form)
    {
        $elementName = $data['element'];
        $data = apply_filters('fluentform_rendering_field_data_' . $elementName, $data, $form);

        $data['attributes']['id'] = $this->makeElementId($data, $form);

        $isMulti = ArrayHelper::get($data, 'settings.enable_select_2') == 'yes';

        if (ArrayHelper::get($data['attributes'], 'multiple')) {
            $data['attributes']['name'] = $data['attributes']['name'] . '[]';
            wp_enqueue_script('choices');
            wp_enqueue_style('ff_choices');
            $data['attributes']['class'] .= ' ff_has_multi_select';
        } else if ($isMulti) {
            wp_enqueue_script('choices');
            wp_enqueue_style('ff_choices');
            $data['attributes']['class'] .= ' ff_has_multi_select';
        }

        if ($maxSelection = ArrayHelper::get($data, 'settings.max_selection')) {
            $data['attributes']['data-max_selected_options'] = $maxSelection;
        }

        $data['attributes']['data-calc_value'] = 0;

        if (!isset($data['attributes']['class'])) {
            $data['attributes']['class'] = '';
        }

        $data['attributes']['class'] = trim('ff-el-form-control ' . $data['attributes']['class']);

        if ($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
            $data['attributes']['tabindex'] = $tabIndex;
        }

        $defaultValues = (array)$this->extractValueFromAttributes($data);

        if ($dynamicValues = $this->extractDynamicValues($data, $form)) {
            $defaultValues = $dynamicValues;
        }

        $elMarkup = "<select " . $this->buildAttributes($data['attributes']) . ">" . $this->buildOptions($data, $defaultValues) . "</select>";

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluentform_rendering_field_html_' . $elementName, $html, $data, $form);
    }

    /**
     * Build options for select
     * @param array $options
     * @return string/html [compiled options]
     */
    protected function buildOptions($data, $defaultValues)
    {
        if (!$formattedOptions = ArrayHelper::get($data, 'settings.advanced_options')) {
            $options = ArrayHelper::get($data, 'options', []);
            $formattedOptions = [];
            foreach ($options as $value => $label) {
                $formattedOptions[] = [
                    'label'      => $label,
                    'value'      => $value,
                    'calc_value' => ''
                ];
            }
        }

        if(ArrayHelper::get($data, 'settings.randomize_options') == 'yes') {
            shuffle($formattedOptions);
        }

        $opts = '';
        if (!empty($data['settings']['placeholder'])) {
            $opts .= '<option value="">' . $data['settings']['placeholder'] . '</option>';
        } else if (!empty($data['attributes']['placeholder'])) {
            $opts .= '<option value="">' . $data['attributes']['placeholder'] . '</option>';
        }

        foreach ($formattedOptions as $option) {
            if (in_array($option['value'], $defaultValues)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

            $atts = [
                'data-calc_value'        => ArrayHelper::get($option, 'calc_value'),
                'data-custom-properties' => ArrayHelper::get($option, 'calc_value'),
                'value'                  => ArrayHelper::get($option, 'value'),
            ];

            $opts .= "<option " . $this->buildAttributes($atts) . " {$selected}>{$option['label']}</option>";
        }

        return $opts;
    }
}
