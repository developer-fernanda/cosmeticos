<?php

namespace FluentForm\App\Services\FormBuilder\Components;

class TextArea extends BaseComponent
{
    /**
     * Compile and echo the html element
     * @param  array     $data [element data]
     * @param  \stdClass $form [Form Object]
     * @return void
     */
    public function compile($data, $form)
    {
        $elementName = $data['element'];
        $data = apply_filters('fluentform_rendering_field_data_'.$elementName, $data, $form);

        $textareaValue = $this->extractValueFromAttributes($data);

        $data['attributes']['class'] = trim('ff-el-form-control '.$data['attributes']['class']);
        $data['attributes']['id'] = $this->makeElementId($data, $form);

        if($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
            $data['attributes']['tabindex'] = $tabIndex;
        }

        $elMarkup = '<textarea %s>%s</textarea>';

        $elMarkup = sprintf(
            $elMarkup,
            $this->buildAttributes($data['attributes']),
            $textareaValue
        );

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}
