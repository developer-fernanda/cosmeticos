<?php

namespace FluentForm\Framework\Foundation;

class HookReference
{
	/**
	 * $ref reference for any hook
	 * @var null
	 */
	private $ref = null;

	/**
	 * construct the instance
	 * @param Application $app
	 * @param reference $ref
	 * @param string $key
	 */
	public function __construct(Application $app, $ref, $key = null)
	{
		$this->app = $app;
		$this->ref = $ref;
		$this->key = $key;
	}

	/**
	 * Save the hook's handler reference
	 * @param  string $key
	 * @return reference
	 */
	public function saveReference($key = null)
	{
		// TODO: Add exception
		$this->app->bindInstance($key ? $key : $this->key, $this->ref);

		return $this->ref;
	}

	/**
	 * Get the reference
	 * @return reference
	 */
	public function reference()
	{
		return $this->ref;
	}
}