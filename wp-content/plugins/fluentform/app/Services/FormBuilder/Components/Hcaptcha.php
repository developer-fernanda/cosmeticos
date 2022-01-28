<?php

namespace FluentForm\App\Services\FormBuilder\Components;

class Hcaptcha extends BaseComponent
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


		$key = get_option('_fluentform_hCaptcha_details');
		if($key && isset($key['siteKey'])) {
			$siteKey = $key['siteKey'];
		} else {
			$siteKey = '';
		}

		if(!$siteKey) {
		    return false;
        }

        wp_enqueue_script(
            'hcaptcha',
            'https://js.hcaptcha.com/1/api.js',
            array(),
            FLUENTFORM_VERSION,
            true
        );

		$hcaptchaBlock = "<div
		data-sitekey='{$siteKey}'
		id='fluentform-hcaptcha-{$form->id}'
		class='ff-el-hcaptcha h-captcha'></div>";

		$label = '';
		if (!empty($data['settings']['label'])) {
			$label = "<div class='ff-el-input--label'><label>{$data['settings']['label']}</label></div>";
		}

		$el = "<div class='ff-el-input--content'><div data-fluent_id='".$form->id."' name='h-captcha-response'>{$hcaptchaBlock}</div></div>";
		$atts = $this->buildAttributes(
			\FluentForm\Framework\Helpers\ArrayHelper::except($data['attributes'], 'name')
		);
		$html = "<div class='ff-el-group' {$atts}>{$label}{$el}</div>";
        echo apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
    }
}
