<?php

namespace FluentForm\Framework\View;

use FluentForm\Framework\Foundation\Provider;

class ViewProvider extends Provider
{
	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
	{
		$this->app->bind('view', function($app) {
			return new View($app);
		}, 'View', 'FluentForm\Framework\View\View');
	}
}
