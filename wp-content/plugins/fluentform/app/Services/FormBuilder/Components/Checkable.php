<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Modules\Component\Component;
use FluentForm\Framework\Helpers\ArrayHelper;

class Checkable extends BaseComponent
{
    /**
     * Compile and echo the html element
     * @param  array $data [element data]
     * @param  stdClass $form [Form Object]
     * @return viod
     */
    public function compile($data, $form)
    {
        $elementName = $data['element'];

        $data = apply_filters('fluentform_rendering_field_data_'.$elementName, $data, $form);

        $data['attributes']['class'] = trim(
            'ff-el-form-check-input ' .
            'ff-el-form-check-'.$data['attributes']['type'].' '.
            ArrayHelper::get($data, 'attributes.class')
        );

        if ($data['attributes']['type'] == 'checkbox') {
            $data['attributes']['name'] = $data['attributes']['name'] . '[]';
        }

        $defaultValues = (array)$this->extractValueFromAttributes($data);

        if($dynamicValues = $this->extractDynamicValues($data, $form)) {
            $defaultValues = $dynamicValues;
        }

        $elMarkup = '';

        $firstTabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex();

        if(!$formattedOptions = ArrayHelper::get($data, 'settings.advanced_options')) {
            $options = ArrayHelper::get($data, 'options', []);
            $formattedOptions = [];
            foreach($options as $value => $label) {
                $formattedOptions[] = [
                    'label' => $label,
                    'value' => $value,
                    'calc_value' => '',
                    'image' => ''
                ];
            }
        }

        $hasImageOption = ArrayHelper::get($data, 'settings.enable_image_input');

        if($hasImageOption) {
            if(empty($data['settings']['layout_class'])) {
                $data['settings']['layout_class'] = 'ff_list_buttons';
            }
            $elMarkup .= '<div class="ff_el_checkable_photo_holders">';
        }

        $data['settings']['container_class'] .= ' '.ArrayHelper::get($data, 'settings.layout_class');

        if(ArrayHelper::get($data, 'settings.randomize_options') == 'yes') {
            shuffle($formattedOptions);
        }

        foreach ($formattedOptions as $option) {

            $displayType = isset($data['settings']['display_type']) ? ' ff-el-form-check-' . $data['settings']['display_type'] : '';
            $parentClass = "ff-el-form-check{$displayType}";

            if (in_array($option['value'], $defaultValues)) {
                $data['attributes']['checked'] = true;
                $parentClass .= ' ff_item_selected';
            } else {
                $data['attributes']['checked'] = false;
            }

            if($firstTabIndex) {
                $data['attributes']['tabindex'] = $firstTabIndex;
                $firstTabIndex = '-1';
            }

            $data['attributes']['value'] = $option['value'];
            $data['attributes']['data-calc_value'] = ArrayHelper::get($option,'calc_value');

            $atts = $this->buildAttributes($data['attributes']);


            $id = $this->getUniqueid(str_replace(['[', ']'], ['', ''], $data['attributes']['name']));


            if($hasImageOption) {
                $parentClass .= ' ff-el-image-holder';
            }

            $elMarkup .= "<div class='{$parentClass}'>";
            // Here we can push the visual items
            if($hasImageOption) {
                $elMarkup .= "<label style='background-image: url({$option['image']})' class='ff-el-image-input-src' for={$id}></label>";
            }

            $elMarkup .= "<label class='ff-el-form-check-label' for={$id}><input {$atts} id='{$id}'> <span>{$option['label']}</span></label>";
            $elMarkup .= "</div>";
        }


        if($hasImageOption) {
            $elMarkup .= '</div>';
        }

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}