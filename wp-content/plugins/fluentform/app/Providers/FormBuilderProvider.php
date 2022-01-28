<?php

namespace FluentForm\App\Providers;

use FluentForm\Framework\Foundation\Provider;
use FluentForm\App\Services\FormBuilder\Components;
use FluentForm\App\Services\FormBuilder\FormBuilder;

class FormBuilderProvider extends Provider
{
	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
    {
        $this->app->bindSingleton('components', function($app) {
            $file = $app->appPath('Services/FormBuilder/DefaultElements.php');
            return new Components($app->load($file));
        }, 'Components');

        $this->app->bind('formBuilder', function($app) {
            return new FormBuilder($app);
        }, 'FormBuilder');
    }

    /**
     * The provider booted method to be called after booting
     * @return void
     */
	public function booted()
    {
    	// ...
    }
}
