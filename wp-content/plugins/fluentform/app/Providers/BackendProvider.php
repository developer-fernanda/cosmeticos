<?php

namespace FluentForm\App\Providers;

use FluentForm\Framework\Foundation\Provider;

/**
 * This provider will be loaded only on backend (admin)
 */

class BackendProvider extends Provider
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
        // ...
    }
}