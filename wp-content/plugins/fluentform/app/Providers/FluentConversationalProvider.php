<?php

namespace FluentForm\App\Providers;

use FluentForm\App\Services\FluentConversational\Classes\Form;
use FluentForm\Framework\Foundation\Provider;

class FluentConversationalProvider extends Provider
{
	public function booting()
	{
		require_once $this->app->appPath() . 'Services/FluentConversational/plugin.php';
	}

	public function booted()
	{
		(new Form)->boot();
	}
}
