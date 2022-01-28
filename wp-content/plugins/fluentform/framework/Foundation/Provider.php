<?php

namespace FluentForm\Framework\Foundation;

abstract class Provider
{
	/**
	 * $app \Framework\Foundation\Application
	 * @var null
	 */
	protected $app = null;

	/**
	 * Build the instance
	 * @param \Framework\Foundation\Application $app
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}
	
	/**
	 * Booted method for any provider
	 * @return void
	 */
	public function booted()
	{
		// ...
	}

	/**
	 * Abstract booting method for provider
	 * @return void
	 */
	public abstract function booting();
}