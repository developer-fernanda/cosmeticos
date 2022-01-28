<?php

namespace FluentForm\App\Services\FormBuilder;

use FluentForm\App\Helpers\Helper;
use FluentForm\Framework\Helpers\ArrayHelper;

class FormBuilder
{
    /**
     * The Applivcation instance
     * @var Framework\Foundation\Application
     */
    protected $app = null;

    protected $form = null;

    /**
     * Conditional logic for elements
     * @var array
     */
    public $conditions = array();

    /**
     * Validation rules for elements
     * @var array
     */
    public $validationRules = array();

    public $tabIndex = 1;

    public $fieldLists = [];

    public $containerCounter;

    /**
     * Construct the form builder instance
     * @param Framework\Foundation\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->containerCounter = 1;
    }

    /**
     * Render the form
     * @param  \StdClass $form [Form entry from database]
     * @return mixed
     */
    public function build($form, $extraCssClass = '', $instanceCssClass = '', $atts = [])
    {
        $this->form = $form;
        $hasStepWrapper = isset($form->fields['stepsWrapper']) && $form->fields['stepsWrapper'];
        
        $labelPlacement = $form->settings['layout']['labelPlacement'];

        $formClass = "frm-fluent-form fluent_form_{$form->id} ff-el-form-{$labelPlacement}";

        if ($extraCssClass) $formClass .= " {$extraCssClass}";

        if ($hasStepWrapper) {
            $formClass .= ' ff-form-has-steps';
        }

        if ($extraFormClass = Helper::formExtraCssClass($form)) {
            $formClass .= ' ' . $extraFormClass;
        }

        $formBody = $this->buildFormBody($form);

        if(strpos($formBody, '{dynamic.')) {
            $formClass .= ' ff_has_dynamic_smartcode';
            wp_enqueue_script('fluentform-advanced');
        }

        $formClass = apply_filters('fluentform_form_class', $formClass, $form);

        if ($form->has_payment) {
            $formClass .= ' fluentform_has_payment';
        }

        $formAttributes = apply_filters('fluent_form_html_attributes', [
            'data-form_id' => $form->id,
            'id' => 'fluentform_'.$form->id,
            'class' => $formClass,
            'data-form_instance' => $instanceCssClass,
            'method' => 'POST'
        ], $form);

        $formAtts = $this->buildAttributes($formAttributes);

        ob_start();

        $wrapperClasses = trim('fluentform fluentform_wrapper_'.$form->id.' '.ArrayHelper::get($atts, 'css_classes'));
        
        echo "<div class='".$wrapperClasses."'>";
        
        do_action('fluentform_before_form_render', $form);
        
        echo "<form ".$formAtts.">";
        
        do_action('fluentform_form_element_start', $form);
        
        echo "<input type='hidden' name='__fluent_form_embded_post_id' value='" . get_the_ID() . "' />";
        
        wp_nonce_field(
            'fluentform-submit-form',
            '_fluentform_' . $form->id . '_fluentformnonce',
            true,
            true
        );
        
        echo $formBody;
        
        echo "</form><div id='fluentform_" . $form->id . "_errors' class='ff-errors-in-stack ";

        echo $extraCssClass . "_errors " . $instanceCssClass . "_errors'></div></div>";
        
        do_action('fluentform_after_form_render', $form);
        
        return ob_get_clean();
    }


    public function buildFormBody($form)
    {
        $hasStepWrapper = isset($form->fields['stepsWrapper']) && $form->fields['stepsWrapper'];
        
        ob_start();
        
        $stepCounter = 1;

        foreach ($form->fields['fields'] as $item) {
            
            if ($hasStepWrapper && $item['element'] == 'form_step') {
                $stepCounter++;
            }

            $this->setUniqueIdentifier($item);

            $item = apply_filters('fluentform_before_render_item', $item, $form);

            do_action('fluentform_render_item_' . $item['element'], $item, $form);

            $this->extractValidationRules($item);

            $this->extractConditionalLogic($item);
        }

        if ($hasStepWrapper) {
            do_action('fluentform_render_item_step_end', $form->fields['stepsWrapper']['stepEnd'], $form);
        } else {
            do_action('fluentform_render_item_submit_button', $form->fields['submitButton'], $form);
        }

        $content = ob_get_clean();

        if ($hasStepWrapper) {
            $startElement = $form->fields['stepsWrapper']['stepStart'];
            
            $steps = ArrayHelper::get($startElement, 'settings.step_titles');
            
            // check if $stepCounter == count()
            if ($stepCounter > count($steps)) {
                $fillCount = $stepCounter - count($steps);
                foreach (range(1, $fillCount) as $item) {
                    $steps[] = '';
                }
                $startElement['settings']['step_titles'] = $steps;
            }

            $this->setUniqueIdentifier($startElement);
            
            ob_start();
            
            do_action('fluentform_render_item_step_start', $startElement, $form);
            
            $stepStatrt = ob_get_clean();
            
            $content = $stepStatrt.$content;
        }

        return $content;
    }

    /**
     * Set unique name/data-name for an element
     * @param array &$item
     * @return  void
     */
    protected function setUniqueIdentifier(&$item)
    {
        if (isset($item['columns'])) {
            $item['attributes']['data-name'] = 'ff_cn_id_'.$this->containerCounter;
            $this->containerCounter++;
            foreach ($item['columns'] as &$column) {
                foreach ($column['fields'] as &$field) {
                    $this->setUniqueIdentifier($field);
                }
            }
        } else {
            if (!isset($item['attributes']['name'])) {
                if($this->form) {
                    if(empty($this->form->attr_name_index)) {
                        $this->form->attr_name_index = 1;
                    } else {
                        $this->form->attr_name_index += 1;
                    }
                    $uniqueId = $this->form->id.'_'.$this->form->attr_name_index;
                } else {
                    $uniqueId = uniqid(rand(), true);
                }

                $item['attributes']['name'] = $item['element'] . '-' . $uniqueId;
            }
            $item['attributes']['data-name'] = $item['attributes']['name'];
            $this->fieldLists[] = $item['element'];
        }
    }

    /**
     * Recursively extract validation rules from a given element
     * @param array $item
     * @return void
     */
    protected function extractValidationRules($item)
    {
        if (isset($item['columns'])) {
            foreach ($item['columns'] as $column) {
                foreach ($column['fields'] as $field) {
                    $this->extractValidationRules($field);
                }
            }
        } elseif (isset($item['fields'])) {
            $rootName = $item['attributes']['name'];
            foreach ($item['fields'] as $key => $innerItem) {
                if ($item['element'] == 'address' || $item['element'] == 'input_name') {
                    $itemName = $innerItem['attributes']['name'];
                    $innerItem['attributes']['name'] = $rootName . '[' . $itemName . ']';
                } else {
                    if ($item['element'] == 'input_repeat' || $item['element'] == 'repeater_field') {
	                   
	                    
                        if(empty($innerItem['settings']['validation_rules']['email'])) {
                            unset($innerItem['settings']['validation_rules']['email']);
                        }
                        $innerItem['attributes']['name'] = $rootName . '[' . $key . ']';
                    } else {
                        $innerItem['attributes']['name'] = $rootName;
                    }
                }
                $this->extractValidationRule($innerItem);
            }
        } elseif ($item['element'] == 'tabular_grid') {
            $gridName = $item['attributes']['name'];
            $gridRows = $item['settings']['grid_rows'];
            $gridType = $item['settings']['tabular_field_type'];
            foreach ($gridRows as $rowKey => $rowValue) {
                if ($gridType == 'radio') {
                    $item['attributes']['name'] = $gridName . '[' . $rowKey . ']';
                    $this->extractValidationRule($item);
                } else {
                    $item['attributes']['name'] = $gridName . '[' . $rowKey . ']';
                    $this->extractValidationRule($item);
                }
            }
        } elseif ($item['element'] == 'chained_select') {
            $chainedSelectName = $item['attributes']['name'];
            foreach ($item['settings']['data_source']['headers'] as $select) {
                $item['attributes']['name'] = $chainedSelectName . '[' . $select . ']';
                $this->extractValidationRule($item);
            }
        } else {
            $this->extractValidationRule($item);
        }
    }

    /**
     * Extract validation rules from a given element
     * @param array $item
     * @return void
     */
    protected function extractValidationRule($item)
    {
        if (isset($item['settings']['validation_rules'])) {
            $rules = $item['settings']['validation_rules'];
            foreach ($rules as $ruleName => $rule) {
                if(isset($rule['message'])) {
                    $rules[$ruleName]['message'] = apply_filters('fluentform_validation_message_'.$ruleName, $rule['message'], $item);
                    $rules[$ruleName]['message'] = apply_filters('fluentform_validation_message_'.$item['element'].'_'.$ruleName, $rule['message'], $item);
                }
            }
            $rules = apply_filters('fluentform_item_rules_' . $item['element'], $rules, $item);
            $this->validationRules[ $item['attributes']['name'] ] = $rules;
        }
    }

    /**
     * Extract conditipnal logic from a given element
     * @param array $item
     * @return void
     */
    protected function extractConditionalLogic($item)
    {
        // If container like element, then recurse
        if (isset($item['columns'])) {
            $containerConditions = false;
            if (isset($item['settings']['conditional_logics'])) {
                $conditionals = $item['settings']['conditional_logics'];
                if (isset($conditionals['status'])) {
                    if ($conditionals['status'] && $conditionals['conditions']) {
                        $containerConditions = $item['settings']['conditional_logics'];
                        $this->conditions[$item['attributes']['data-name']] = $containerConditions;
                    }
                }
            }

            foreach ($item['columns'] as $column) {
                foreach ($column['fields'] as $field) {
                    if($containerConditions) {
                        $field['container_conditions'] = $containerConditions;
                    }
                    $this->extractConditionalLogic($field);
                }
            }
        } elseif (isset($item['settings']['conditional_logics'])) {
            $conditionals = $item['settings']['conditional_logics'];
            if (isset($conditionals['status'])) {
                if ($conditionals['status'] && $conditionals['conditions']) {
                    $this->conditions[$item['attributes']['data-name']] = $item['settings']['conditional_logics'];
                }
            }
            if(isset($item['container_conditions'])) {
                if(!isset($this->conditions[$item['attributes']['data-name']])) {
                    $this->conditions[$item['attributes']['data-name']] = [
                        'conditions' => [],
                        'status' => false,
                        'type' => 'any'
                    ];
                }
                $this->conditions[$item['attributes']['data-name']]['container_condition'] = $item['container_conditions'];
            }
        }
    }

    /**
     * Build attributes for any html element
     * @param  array  $attributes
     * @return string [Compiled key='value' attributes]
     */
    protected function buildAttributes($attributes, $form = null)
    {
        $atts = '';
        foreach ($attributes as $key => $value) {
            if ($value || $value === 0 || $value === '0') {
                $value = htmlspecialchars($value);
                $atts .= $key.'="'.$value.'" ';
            }
        }
        return $atts;
    }
}
