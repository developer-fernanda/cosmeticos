<?php

namespace FluentForm\Framework\Foundation;

trait FacadeLoaderTrait
{
	/**
	 * Register facade/alias loader
	 * @return void
	 */
	protected function registerAppFacadeLoader()
	{
		$this->isFacadeLoaderRegistered = true;
		spl_autoload_register([$this, 'aliasLoader'], true, false);
	}
	
	/**
	 * Facad/Alias loader
	 * @param  [type] $class [description]
	 * @return [type]        [description]
	 */
	protected function aliasLoader($class)
	{
		$namespace = $this->getNamespace();
		if ($namespace == substr($class, 0, strlen($namespace))) {
			$parts = explode('\\', $class);
			if (count($parts) == 2) {
				if (array_key_exists($parts[1], static::$container['facades'])) {
					$containerKey = static::$container['facades'][$facade = $parts[1]];
					$path = $this->storagePath().'framework/facades/';
					if (!file_exists($file = $path.$facade.'.php')) {
						if (!file_exists($path)) {
							mkdir($path, 0777, true);
						}
						file_put_contents($file, $this->getFileData($facade, $containerKey));
					}
					include $file;
				}
			}
		}
	}

	/**
	 * Retrieve facade file content
	 * @param  string $alias
	 * @param  string $key
	 * @return string
	 */
	protected function getFileData($alias, $key)
	{
		return str_replace(
			['DummyNamespace', 'DummyClass', 'DummyKey'],
			[$this->getNamespace(), $alias, $key],
			file_get_contents($this->frameworkPath().'Foundation/Facade.stub')
		);
	}
}
