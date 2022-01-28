<?php

namespace FluentForm\App\Providers;

use FluentForm\Framework\Foundation\Provider;

class FluentValidatorProvider extends Provider
{
    public function booting()
    {
        require_once $this->app->appPath().'Services/fluentvalidator/fluentvalidator.php';
    }
}