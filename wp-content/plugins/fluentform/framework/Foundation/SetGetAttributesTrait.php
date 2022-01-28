<?php

namespace FluentForm\Framework\Foundation;

trait SetGetAttributesTrait
{
	/**
	 * Dynamic getter for application
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->make($key);
	}

	/**
	 * Dynamic setter for application
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set($key, $value)
	{
	    $this[$key] = $value;
	}

	/**
	 * Getter for retrieving plugin's base file path
	 * @return string
	 */
	public function getBaseFile()
	{
		return $this->baseFile;
	}

	/**
	 * Get application's main config
	 * @return array
	 */
	public function getAppConfig()
	{
		return $this->appConfig;
	}

	/**
	 * Get application's providers
	 * @param  string $type [core|plugin]
	 * @return array
	 */
	public function getProviders($type = null)
	{
		$providers = $this->getAppConfig()['providers'];
		
		return $type ? $providers[$type] : $providers;
	}

	/**
	 * Get plugin name
	 * @return string
	 */
	public function getName()
	{
		return $this->getAppConfig()['plugin_name'];
	}

	/**
	 * Get plugin slug
	 * @return string
	 */
	public function getSlug()
	{
		return $this->appConfig['plugin_slug'];
	}

	/**
	 * Get plugin version
	 * @return string
	 */
	public function getVersion()
	{
		return $this->appConfig['plugin_version'];
	}

	/**
	 * Get plugin root namespace
	 * @return string
	 */
	public function getNamespace()
	{
		return $this->getAppConfig()['autoload']['namespace'];
	}

	/**
	 * Get plugin text domain
	 * @return string
	 */
	public function getTextDomain()
	{
		return $this->appConfig['plugin_text_domain']
		? $this->appConfig['plugin_text_domain']
		: $this->appConfig['plugin_slug'];
	}

	/**
	 * Get application evironment
	 * @return string
	 */
	public function getEnv()
	{
		if (isset($this->getAppConfig()['env'])) {
			return $this->getAppConfig()['env'];
		}
	}
}