<?php

namespace FluentForm\App\Providers;

use FluentForm\App\Services\Migrator\Bootstrap;
use FluentForm\Framework\Foundation\Provider;

class MigratorProvider extends Provider
{
	public function booting()
	{
		require_once $this->app->appPath() . 'Services/Migrator/Bootstrap.php';
	}

	public function booted()
	{
		(new Bootstrap())->boot();
	}
}
