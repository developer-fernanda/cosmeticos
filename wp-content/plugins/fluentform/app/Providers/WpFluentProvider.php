<?php

namespace FluentForm\App\Providers;

use FluentForm\Framework\Foundation\Provider;

class WpFluentProvider extends Provider
{
    public function booting()
    {
        require_once $this->app->appPath().'Services/wpfluent/wpfluent.php';
    }
}