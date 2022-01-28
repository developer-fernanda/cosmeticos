<?php

namespace FluentForm\App\Providers;

use FluentForm\App\Services\AdminNotices;
use FluentForm\Framework\Foundation\Provider;

class AdminNoticeProvider extends Provider
{
	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
    {
        $this->app->bindSingleton('adminNotice', function($app) {
        	return new AdminNotices($this->app);
        }, 'AdminNotice');
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