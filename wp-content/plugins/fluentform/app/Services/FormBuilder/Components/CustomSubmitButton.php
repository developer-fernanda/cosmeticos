<?php
namespace FluentForm\App\Services\FormBuilder\Components;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Services\FormBuilder\BaseFieldManager;
use FluentForm\Framework\Helpers\ArrayHelper;

class CustomSubmitButton extends BaseFieldManager
{
    public function __construct()
    {
        parent::__construct(
            'custom_submit_button',
            'Custom Submit Button',
            ['submit', 'button', 'custom'],
            'advanced'
        );
    }

    public function pushFormInputType($types)
    {
        return $types;
    }

    function getComponent()
    {
        return [
            'index'          => 15,
            'element'        => $this->key,
            'attributes'     => [
                'class' => '',
                'type'  => 'submit'
            ],
            'settings'       => [
                'button_style'       => '',
                'button_size'        => 'md',
                'align'              => 'left',
                'container_class'    => '',
                'current_state'      => 'normal_styles',
                'background_color'   => 'rgb(64, 158, 255)',
                'color'              => 'rgb(255, 255, 255)',
                'hover_styles'       => (object)[
                    'backgroundColor' => '#ffffff',
                    'borderColor'     => '#409EFF',
                    'color'           => '#409EFF',
                    'borderRadius'    => '',
                    'minWidth'        => '100%'
                ],
                'normal_styles'      => (object)[
                    'backgroundColor' => '#409EFF',
                    'borderColor'     => '#409EFF',
                    'color'           => '#ffffff',
                    'borderRadius'    => '',
                    'minWidth'        => '100%'
                ],
                'button_ui'          => (object)[
                    'text'    => 'Submit',
                    'type'    => 'default',
                    'img_url' => ''
                ],
                'conditional_logics' => []
            ],
            'editor_options' => [
                'title'      => $this->title,
                'icon_class' => 'dashicons dashicons-arrow-right-alt',
                'template'   => 'customButton'
            ],
        ];
    }

    public function pushConditionalSupport($conditonalItems)
    {
        return $conditonalItems;
    }


    public function getGeneralEditorElements()
    {
        return [
            'btn_text',
            'button_ui',
            'button_style',
            'button_size',
            'align',
        ];
    }

    public function getAdvancedEditorElements()
    {
        return [
            'container_class',
            'class',
            'conditional_logics',
        ];
    }

    public function render($data, $form)
    {
        // @todo: We will remove this in our next version [added: 4.0.0]
        if( class_exists('\FluentFormPro\Components\CustomSubmitField') ) {
            return '';
        }

        add_filter('fluentform_is_hide_submit_btn_' . $form->id, '__return_true');

        $elementName = $data['element'];
        $data = apply_filters('fluentform_rendering_field_data_' . $elementName, $data, $form);

        $btnStyle = ArrayHelper::get($data['settings'], 'button_style');

        $btnSize = 'ff-btn-';
        $btnSize .= isset($data['settings']['button_size']) ? $data['settings']['button_size'] : 'md';
        $oldBtnType = isset($data['settings']['button_style']) ? '' : ' ff-btn-primary ';

        $align = 'ff-el-group ff-text-' . @$data['settings']['align'];

        $btnClasses = [
            'ff-btn ff-btn-submit',
            $oldBtnType,
            $btnSize,
            $data['attributes']['class']
        ];

        if($btnStyle == 'no_style') {
            $btnClasses[] = 'ff_btn_no_style';
        } else {
            $btnClasses[] = 'ff_btn_style';
        }

        $data['attributes']['class'] = trim(implode(' ', array_filter($btnClasses)));

        if($tabIndex = \FluentForm\App\Helpers\Helper::getNextTabIndex()) {
            $data['attributes']['tabindex'] = $tabIndex;
        }

        $styles = '';
        if (ArrayHelper::get($data, 'settings.button_style') == '') {
            $data['attributes']['class'] .= ' wpf_has_custom_css';
            // it's a custom button
            $buttonActiveStyles = ArrayHelper::get($data, 'settings.normal_styles', []);
            $buttonHoverStyles = ArrayHelper::get($data, 'settings.hover_styles', []);

            $activeStates = '';
            foreach ($buttonActiveStyles as $styleAtr => $styleValue) {
                if (!$styleValue) {
                    continue;
                }
                if ($styleAtr == 'borderRadius') {
                    $styleValue .= 'px';
                }
                $activeStates .= ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $styleAtr)), '_') . ':' . $styleValue . ';';
            }
            if ($activeStates) {
                $styles .= 'form.fluent_form_' . $form->id . ' .wpf_has_custom_css.ff-btn-submit { ' . $activeStates . ' }';
            }
            $hoverStates = '';
            foreach ($buttonHoverStyles as $styleAtr => $styleValue) {
                if (!$styleValue) {
                    continue;
                }
                if ($styleAtr == 'borderRadius') {
                    $styleValue .= 'px';
                }
                $hoverStates .= ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $styleAtr)), '-') . ':' . $styleValue . ';';
            }
            if ($hoverStates) {
                $styles .= 'form.fluent_form_' . $form->id . ' .wpf_has_custom_css.ff-btn-submit:hover { ' . $hoverStates . ' } ';
            }
        } else if($btnStyle != 'no_style') {
            $styles .= 'form.fluent_form_' . $form->id . ' .ff-btn-submit { background-color: ' . ArrayHelper::get($data, 'settings.background_color') . '; color: ' . ArrayHelper::get($data, 'settings.color') . '; }';
        }

        $atts = $this->buildAttributes($data['attributes']);
        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';
        $cls = trim($align . ' ' . $data['settings']['container_class'] . ' ' . $hasConditions);

        $html = "<div class='{$cls} ff_submit_btn_wrapper ff_submit_btn_wrapper_custom'>";

        // ADDED IN v1.2.6 - updated in 1.4.4
        if (isset($data['settings']['button_ui'])) {
            if ($data['settings']['button_ui']['type'] == 'default') {
                $html .= '<button ' . $atts . '>' . $data['settings']['button_ui']['text'] . '</button>';
            } else {
                $html .= "<button class='ff-btn-submit' type='submit'><img style='max-width: 200px;' src='{$data['settings']['button_ui']['img_url']}' alt='Submit Form'></button>";
            }
        } else {
            $html .= '<button ' . $atts . '>' . $data['settings']['btn_text'] . '</button>';
        }

        if ($styles) {
            $html .= '<style>' . $styles . '</style>';
        }

        $html .= '</div>';

        echo apply_filters('fluentform_rendering_field_html_' . $elementName, $html, $data, $form);
    }
}