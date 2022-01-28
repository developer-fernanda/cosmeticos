<?php

namespace FluentForm\App\Services\FormBuilder;

use FluentForm\App\Services\FormBuilder\Components\BaseComponent;

abstract class BaseFieldManager extends BaseComponent
{
    protected $key = '';
    protected $title = '';
    protected $tags = [];
    protected $position = 'advanced';

    public function __construct($key, $title, $tags = [], $position = 'advanced')
    {
        $this->key = $key;
        $this->position = $position;
        $this->title = $title;
        $this->tags = $tags;
        $this->register();
    }

    public function register()
    {
        add_filter('fluent_editor_components', array($this, 'pushComponent'));
        add_filter('fluent_editor_element_settings_placement', array($this, 'pushEditorElementPositions'));
        add_filter('fluent_editor_element_search_tags', array($this, 'pushTags'), 10, 2);
        add_action('fluentform_render_item_' . $this->key, array($this, 'render'), 10, 2);
        /*
         * This is internal use.
         * Push field type to the fluentform field types to be available in FormFieldParser.
         */
        add_filter('fluentform_form_input_types', array($this, 'pushFormInputType'));

        add_filter('fluent_editor_element_customization_settings', function ($settings) {
            if ($customSettings = $this->getEditorCustomizationSettings()) {
                $settings = array_merge($settings, $customSettings);
            }

            return $settings;
        });


        add_filter('fluentform_supported_conditional_fields', array($this, 'pushConditionalSupport'));

    }

    public function pushConditionalSupport($conditonalItems)
    {
        $conditonalItems[] = $this->key;
        return $conditonalItems;
    }

    public function pushFormInputType($types)
    {
        $types[] = $this->key;
        return $types;
    }

    public function pushComponent($components)
    {
        $component = $this->getComponent();

        if ($component) {
            $components[$this->position][] = $component;
        }

        return $components;
    }

    public function pushEditorElementPositions($placement_settings)
    {
        $placement_settings[$this->key] = array(
            'general' => $this->getGeneralEditorElements(),
            'advanced' => $this->getAdvancedEditorElements(),
            'generalExtras' => $this->generalEditorElement(),
            'advancedExtras' => $this->advancedEditorElement()
        );

        return $placement_settings;
    }

    public function generalEditorElement()
    {
        return [];
    }

    public function advancedEditorElement()
    {
        return [];
    }

    public function getGeneralEditorElements()
    {
        return [
            'label',
            'admin_field_label',
            'placeholder',
            'label_placement',
            'validation_rules',
        ];
    }

    public function getAdvancedEditorElements()
    {
        return [
            'name',
            'help_message',
            'container_class',
            'class',
            'conditional_logics',
        ];
    }

    public function getEditorCustomizationSettings()
    {
        return [];
    }

    public function pushTags($tags, $form)
    {
        if ($this->tags) {
            $tags[$this->key] = $this->tags;
        }
        return $tags;
    }

    abstract function getComponent();

    abstract function render($element, $form);
}
