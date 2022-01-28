<?php

namespace FluentForm\Framework\Foundation;

use FluentForm\Framework\Foundation\Provider;

class AppProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     * @return void
     */
    public function booting()
    {
        $this->app->bind(
            'app', $this->app, 'App', 'FluentForm\Framework\Foundation\Application'
        );

        // Framework is booted and ready
        $this->app->booted(function($app) {
            $app->load($app->appPath('Global/Common.php'));
        });
    }

    /**
     * The provider booted method to be called after booting
     * @return void
     */
    public function booted()
    {
        // Application is booted and ready
        $this->app->ready(function($app) {
            $app->load($app->appPath('Hooks/Common.php'));
            if ($app->isUserOnAdminArea()) {
                $app->load($app->appPath('Hooks/Ajax.php'));
                $app->load($app->appPath('Hooks/Backend.php'));
            } else {
                $app->load($app->appPath('Hooks/Frontend.php'));   
            }
        });
    }
}
