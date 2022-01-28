<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\App\Services\FormBuilder\Components\Select;

class Name extends Select
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

        $rootName = $data['attributes']['name'];

        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';
        
        if (empty($data['attributes']['class'])) {
            $data['attributes']['class'] = '';
        }

        $data['attributes']['class'] .= $hasConditions;
        $data['attributes']['class'] .= ' ff-field_container ff-name-field-wrapper';
        if($containerClass = ArrayHelper::get($data, 'settings.container_class')) {
            $data['attributes']['class'] .= ' '.$containerClass;
        }
        $atts = $this->buildAttributes(
            ArrayHelper::except($data['attributes'], 'name')
        );

        $html = "<div {$atts}>";
        $html .= "<div class='ff-t-container'>";

        $labelPlacement = ArrayHelper::get($data, 'settings.label_placement');
        $labelPlacementClass = '';
        
        if ($labelPlacement) {
            $labelPlacementClass = ' ff-el-form-'.$labelPlacement;
        }
       
        foreach ($data['fields'] as $field) {
            if ($field['settings']['visible']) {
                $fieldName = $field['attributes']['name'];
                $field['attributes']['name'] = $rootName . '[' . $fieldName . ']';
                @$field['attributes']['class'] = trim(
                    'ff-el-form-control ' .
                    $field['attributes']['class']
                );

                if ($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
                    $field['attributes']['tabindex'] = $tabIndex;
                }


                @$field['settings']['container_class'] .= $labelPlacementClass;

                $field['attributes']['id'] = $this->makeElementId($field, $form);
                $nameTitleClass= "";
                if($field['attributes']['type'] == 'select'){
                    if(!defined('FLUENTFORMPRO')){
                        continue;
                    }
                    $nameTitleClass=  ' ff-name-title';
    
                    $defaultValues = (array)$this->extractValueFromAttributes($field);
                  
                    $elMarkup = "<select " . $this->buildAttributes($field['attributes']) . ">" . $this->buildOptions($field, $defaultValues) . "</select>";
    
                }else{
                    $elMarkup = "<input ".$this->buildAttributes($field['attributes']).">";
                    
                }

                $inputTextMarkup = $this->buildElementMarkup($elMarkup, $field, $form);
                $html .= "<div class='ff-t-cell {$nameTitleClass}'>{$inputTextMarkup}</div>";
            }
        }
        $html .= "</div>";
        $html .= "</div>";
        echo apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}
