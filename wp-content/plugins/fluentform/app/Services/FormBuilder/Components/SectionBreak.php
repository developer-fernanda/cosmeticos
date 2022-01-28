<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\Framework\Helpers\ArrayHelper;

class SectionBreak extends BaseComponent
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

        $alignment = ArrayHelper::get($data, 'settings.align');
        if($alignment) {
            $data['attributes']['class'] .= ' ff_'.$alignment;
        }

        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';
		$cls = trim($this->getDefaultContainerClass().' '.$hasConditions);
		$data['attributes']['class'] = $cls .' ff-el-section-break '. $data['attributes']['class'];
		$data['attributes']['class'] = trim($data['attributes']['class']);
		$atts = $this->buildAttributes(
			\FluentForm\Framework\Helpers\ArrayHelper::except($data['attributes'], 'name')
		);
		$html = "<div {$atts}>";
        $html .= "<h3 class='ff-el-section-title'>{$data['settings']['label']}</h3>";
        $html .= "<div class='ff-section_break_desk'>{$data['settings']['description']}</div>";
        $html .= "<hr />";
        $html .= "</div>";
        echo apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}
