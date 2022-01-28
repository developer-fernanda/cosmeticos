<?php

/**
 * This provider will be loaded always (admin/public)
 */

namespace FluentForm\App\Providers;

use FluentForm\Framework\Foundation\Provider;

class CommonProvider extends Provider
{
	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
    {
    	// ...
    }

    /**
     * The provider booted method to be called after booting
     * @return void
     */
	public function booted()
    {
        /**
         * Fire fluentform-loaded event when app is ready.
         * The ready event will be fired by framework once
         * the framework is booted and the app (plugin) is
         * completely ready.
         */
        $this->app->ready(function($app) {
            $app->addAction('init', function() use ($app) {
                $app->doAction('fluentform-loaded', $app);
            });
        });

        /**
         * Register "admin_init" hook to run before ajax callbacks
         */
        $this->app->addAction('admin_init', function() {
            if (defined('DOING_AJAX') && DOING_AJAX) {
                $action = $this->app->request->get('action');
                if($this->app->has("__ajax_before__{$action}")) {
                    $callback = $this->app->make("__ajax_before__{$action}");
                    return $callback($this->app);
                }
            }
        });
    }
}