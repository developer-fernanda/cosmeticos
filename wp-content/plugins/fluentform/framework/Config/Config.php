<?php

namespace FluentForm\Framework\Config;

use FluentForm\Framework\Helpers\ArrayHelper;

class Config implements \ArrayAccess
{
	/**
	 * All array items from all files from /config directory
	 * @var array
	 */
	protected $repository = array();

	/**
	 * Initiate the instance
	 * @param array $repository
	 */
	public function __construct($repository = array())
	{
		$this->repository = $repository;
	}

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return ArrayHelper::has($this->repository, $key);
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function all()
    {
        return $this->repository;
    }

	/**
     * Get the specified configuration value.
     *
     * @param  array|string  $key
     * @param  mixed   $default
     * @return mixed
     */
	public function get($key = null, $default = null)
	{
		return ArrayHelper::get($this->repository, $key, $default);
	}

	/**
     * Set a given configuration value.
     *
     * @param  array|string  $key
     * @param  mixed   $value
     * @return void
     */
	public function set($key, $value)
	{
		$keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
        	return ArrayHelper::set($this->repository, $key, $value);
        }
	}

	/**
	 * Dynamic Getter
	 * @param  string $key
	 * @return mixed
	 */
	public function __get($key = null)
	{
		return $this->get($key);
	}

	/**
	 * Dynamic Setter
	 * @param  string $key
	 * @param  mixed $key
	 * @return void
	 */
	public function __set($key, $value)
	{
		return $this->set($key, $value);
	}

	/**
     * Determine if the given item exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get an item.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set an item.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset an item.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->set($key, null);
    }
}