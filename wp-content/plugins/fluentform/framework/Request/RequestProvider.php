<?php

namespace FluentForm\Framework\Request;

use FluentForm\Framework\Foundation\Provider;

class RequestProvider extends Provider
{
	public function booting() {}

	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booted()
	{
		$this->app->bindInstance(
			'request',
			new Request($this->app, $_GET, $_POST, $_FILES),
			'Request',
			'FluentForm\Framework\Request\Request'
		);
	}
}
