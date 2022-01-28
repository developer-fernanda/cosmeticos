<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;

class Rating extends BaseComponent
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

        $data['attributes']['type'] = 'radio';

		$defaultValues = (array) $this->extractValueFromAttributes($data);

		$elMarkup = "<div class='ff-el-ratings jss-ff-el-ratings'>";
		$ratingText = "";

		foreach ( $data['options'] as $value => $label ) {
			$starred = '';
			if(in_array($value, $defaultValues)) {
				$data['attributes']['checked'] = true;
				$starred = 'active';
			} else {
				$data['attributes']['checked'] = false;
			}

            if($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
                $data['attributes']['tabindex'] = $tabIndex;
            }

			$atts = $this->buildAttributes($data['attributes']);
			$id = $this->getUniqueid(str_replace(['[', ']'], ['', ''], $data['attributes']['name']));
			
			$elMarkup .= "<label class='{$starred}'><input {$atts} id={$id} value='{$value}'>";
			$elMarkup .= '<?xml version="1.0" encoding="iso-8859-1"?><svg class="jss-ff-svg ff-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve"><polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>';
			$elMarkup .= '</label>';

			if (ArrayHelper::get($data, 'settings.show_text') == 'yes') {
				$displayDefaultText = in_array($value, $defaultValues) ? 'display: inline-block' : 'display: none';
				$ratingText .= "<span style='{$displayDefaultText}' class='ff-el-rating-text' data-id='{$id}'>{$label}</span>";
			}
		};

		$elMarkup .= "</div>".$ratingText;

		$html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}
