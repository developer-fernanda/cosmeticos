<?php namespace FluentForm\App\Modules;

use FluentForm\App;
use FluentForm\View;

class DocumentationModule
{
	
	public function render()
	{
		return View::make('admin.docs.index', array(
			'icon_path_url' => App::publicUrl(),
			'user_guides' => $this->getUserGuides()
		));
	}
	
	private function getUserGuides()
	{
		$guides = array(
			array(
				'title' => __('Adding a new form', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/getting-started/create-fluent-form/'
			),
			array(
				'title' => __('Setting up form submission confirmation', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/getting-started/submission-confirmation-message/'
			),
			array(
				'title' => __('Form layout settings', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/getting-started/form-layout-settings/'
			),
			array(
				'title' => __('Conditional logics', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/advanced-features-functionalities-in-wp-fluent-form/conditional-logic-fluent-form/'
			),
			array(
				'title' => __('Managing form submissions', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/view-submitted-form-data-in-wp-fluent-forms/view-manage-submitted-form-entries/'
			),
			array(
				'title' => __('Setting up email notifications', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/getting-started/email-notification/'
			),
			array(
				'title' => __('MailChimp integration', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/integrations-availabel-in-wp-fluent-form/mailchimp-integration/'
			),
            array(
				'title' => __('Slack integration', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/integrations-availabel-in-wp-fluent-form/slack-integration-fluentform/'
			),
			array(
				'title' => __('Form restrictions and scheduling', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/advanced-features-functionalities-in-wp-fluent-form/form-restrictions/'
			),
            array(
				'title' => __('Setup conditional confirmation messages', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/advanced-features-functionalities-in-wp-fluent-form/conditional-confirmation-wp-fluent-form/'
			),
            array(
				'title' => __('Predefined form fields', 'fluentform'),
				'link' => 'https://wpmanageninja.com/docs/fluent-form/field-types/'
			),
		);
		return apply_filters('fluentform_user_guide_links', $guides);
	}
}
