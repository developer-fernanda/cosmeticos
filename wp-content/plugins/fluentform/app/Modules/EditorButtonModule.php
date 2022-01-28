<?php namespace FluentForm\App\Modules;

use FluentForm\App;
use FluentForm\Config;
use FluentForm\Framework\Helpers\ArrayHelper;
use FluentForm\Request;
use FluentForm\View;

class EditorButtonModule
{
	public function addButton()
	{
		if (! $this->pageSupportedMediaButtons()) {
			return;
		}

		$this->addMceButtonAssets();

		$label = __('Add Form', 'fluentform');
		$url = App::publicUrl('img/icon_black_small.png');
		echo "<button id='fluent_form_insert_button' class='button'><span style='background-image: url({$url}); width: 16px;height: 16px;background-repeat: no-repeat;display: inline-block;background-size: contain;opacity: 0.4;margin-right: 5px;vertical-align: middle;'></span>{$label}</button>";
	}
	
	private function addMceButtonAssets()
	{
		wp_enqueue_script(
			'fluentform_editor_script',
			fluentformMix('js/fluentform_editor_script.js'),
			array('jquery'),
			FLUENTFORM_VERSION
		);

		$forms = wpFluent()->table('fluentform_forms')
					->select(array('id', 'title'))
					->get();
		
		$forms = array_map(function($item) {
			return array('value' => $item->id, 'text'=> $item->title);
		}, $forms);

		wp_localize_script('fluentform_editor_script', 'fluentform_editor_vars', array(
			'forms' => $forms
		));
	}
	
	private function pageSupportedMediaButtons() 
	{
		$currentPage = basename( $_SERVER['PHP_SELF'] );
		$isEligiblePage = in_array( $currentPage, array(
			'post.php',
			'page.php',
			'page-new.php',
			'post-new.php',
			'customize.php',
		));

		if ($isEligiblePage) {
            $option = get_option('_fluentform_global_form_settings');
            $isEligiblePage = ArrayHelper::get($option, 'misc.classicEditorButton') == 'yes';
        }

		return apply_filters( 'fluentform_display_add_form_button', $isEligiblePage );
	}

	private function getMenuIcon()
	{
		return 'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><defs><style>.cls-1{fill:#fff;}</style></defs><title>dashboard_icon</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M15.57,0H4.43A4.43,4.43,0,0,0,0,4.43V15.57A4.43,4.43,0,0,0,4.43,20H15.57A4.43,4.43,0,0,0,20,15.57V4.43A4.43,4.43,0,0,0,15.57,0ZM12.82,14a2.36,2.36,0,0,1-1.66.68H6.5A2.31,2.31,0,0,1,7.18,13a2.36,2.36,0,0,1,1.66-.68l4.66,0A2.34,2.34,0,0,1,12.82,14Zm3.3-3.46a2.36,2.36,0,0,1-1.66.68H3.21a2.25,2.25,0,0,1,.68-1.64,2.36,2.36,0,0,1,1.66-.68H16.79A2.25,2.25,0,0,1,16.12,10.53Zm0-3.73a2.36,2.36,0,0,1-1.66.68H3.21a2.25,2.25,0,0,1,.68-1.64,2.36,2.36,0,0,1,1.66-.68H16.79A2.25,2.25,0,0,1,16.12,6.81Z"/></g></g></svg>');
	}
}
