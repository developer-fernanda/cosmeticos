<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\Framework\Helpers\ArrayHelper;

class Address extends BaseComponent
{
    /**
     * Wrapper class for address element
     * @var string
     */
    protected $wrapperClass = 'fluent-address';

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

        $rootName = $data['attributes']['name'];
        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';
        $data['attributes']['class'] .= ' ff-name-address-wrapper ' . $this->wrapperClass . ' ' . $hasConditions;
        $data['attributes']['class'] = trim($data['attributes']['class']);

        if(ArrayHelper::get($data, 'settings.enable_g_autocomplete') == 'yes') {
            $data['attributes']['class'] .= ' ff_map_autocomplete';
            if(ArrayHelper::get($data, 'settings.enable_g_map') == 'yes'){
                $data['attributes']['data-ff_with_g_map'] = '1';
            }
            $data['attributes']['data-ff_with_auto_locate'] = ArrayHelper::get($data, 'settings.enable_auto_locate',false) ;
            do_action('fluentform_address_map_autocomplete', $data, $form);
        }

        $atts = $this->buildAttributes(
            \FluentForm\Framework\Helpers\ArrayHelper::except($data['attributes'], 'name')
        );

        ob_start();
        echo "<div {$atts}>";
        do_action('fluentform_rendering_address_field', $data, $form);
        if ($data['settings']['label']):
            echo "<div class='ff-el-input--label'>";
            echo "<label>{$data['settings']['label']}</label>";
            echo "</div>";
        endif;
        echo "<div class='ff-el-input--content'>";

        $visibleFields = array_chunk(array_filter($data['fields'], function ($field) {
            return $field['settings']['visible'];
        }), 2);

		$googleAutoComplete = ArrayHelper::get($data, 'settings.enable_g_autocomplete') === 'yes';
		foreach ($visibleFields as $chunked) {
            echo "<div class='ff-t-container'>";
            foreach ($chunked as $item) {
                if ($item['settings']['visible']) {
                    $itemName = $item['attributes']['name'];
                    $item['attributes']['data-key_name'] = $itemName;
                    $item['attributes']['name'] = $rootName . '[' . $itemName . ']';

					if ($item['element'] === 'select_country' && $googleAutoComplete) {
						$selectedCountries = (array) ArrayHelper::get($item, 'attributes.value', []);
						if (ArrayHelper::get($item, 'settings.country_list.active_list') === 'visible_list') {
							$selectedCountries = array_unique(
								array_merge(
									$selectedCountries,
									ArrayHelper::get($item, 'settings.country_list.visible_list', [])
								)
							);
						}
						$item['attributes']['data-autocomplete_restrictions'] = json_encode(array_filter($selectedCountries));
					}

                    $item = apply_filters('fluentform_before_render_item', $item, $form);
                    echo "<div class='ff-t-cell'>";
                    do_action('fluentform_render_item_' . $item['element'], $item, $form);
                    echo "</div>";
                }
            }
            echo "</div>";
        }

        echo "</div>";
        echo "</div>";

        $html = ob_get_clean();
        echo apply_filters('fluentform_rendering_field_html_' . $elementName, $html, $data, $form);
    }
}
