<?php

return array(
	'env' => 'production',
	'providers' => array(
		'core' => array(
			'FluentForm\Framework\Foundation\AppProvider',
			'FluentForm\Framework\Config\ConfigProvider',
			'FluentForm\App\Providers\FluentValidatorProvider',
			'FluentForm\Framework\Request\RequestProvider',
			'FluentForm\Framework\View\ViewProvider',
		),
		'plugin' => array(

			'common' => array(
				'FluentForm\App\Providers\CommonProvider',
				'FluentForm\App\Providers\FormBuilderProvider',
                'FluentForm\App\Providers\WpFluentProvider',
				'FluentForm\App\Providers\FluentConversationalProvider',
			),
			
			'backend' => array(
				'FluentForm\App\Providers\BackendProvider',
                'FluentForm\App\Providers\MenuProvider',
				'FluentForm\App\Providers\AdminNoticeProvider',
                'FluentForm\App\Providers\MigratorProvider',
			),

			'frontend' => array(
				'FluentForm\App\Providers\FrontendProvider',
			),
		),
	),
);
