<?php

namespace FluentForm\App\Modules\Form\Settings;

use FluentForm\App;
use FluentForm\App\Modules\Acl\Acl;
use FluentForm\Framework\Foundation\Application;

class ExtraSettings
{
    /**
     * @var \FluentForm\Framework\Request\Request $request
     */
    protected $request;

    /**
     * @var \WpFluent\QueryBuilder\QueryBuilderHandler
     */
    protected $form_model;

    /**
     * Construct the object
     * @throws \Exception
     * @return  void
     */
    public function __construct(Application $application)
    {
        $this->request = $application->request;
        $this->form_model = wpFluent()->table('fluentform_forms');
    }
	
    /**
     * Get extra settig navigations
     * @return void
     */
    public function getExtraSettingNavs()
    {
    	$formId = $this->request->get('form_id');

	    $extraSettings = array(
	    	array(
	    		'name' => 'web_hooks',
			    'label' => __('Web Hooks', 'fluentform'),
			    'action' => 'fluentform_get_settings_page',
			    'addon' => 'Fluent Web Hooks'
		    ),
		    array(
			    'name' => 'trello',
			    'label' => __('Trello', 'fluentform'),
			    'action' => 'fluentform_get_settings_page',
			    'addon' => 'Trello'
		    )
	    );

    	wp_send_json_success(['setting_navs' => $extraSettings], 200);
    }
    
    /**
     * Get extra settigs component
     * @return void
     */
    public function getExtraSettingsComponent()
    {
    	$formId = $this->request->get('form_id');
	    $module = $this->request->get('module');
	    
    	$component = array(
    	    'name' => 'fluentform_settings_'.$module,
		    'props' => ['form_id'],
		    'template' => "<p>Setting Not Found</p>"
	    );

	    $component = apply_filters('fluentform_settings_module_'.$module, $component, $formId);
    	
    	wp_send_json_success(array(
    		'component' => $component,
		    'name' => 'fluentform_settings_'.$module,
		    'js_url' => site_url().'/test.js'
	    ));
    }
    
    /**
     * Get trello settigs
     * @return void
     */
    public function getTrelloSettingsComponent($component, $formId)
    {
    	return $component;
    }
}
