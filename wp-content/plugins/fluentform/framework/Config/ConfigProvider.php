<?php

namespace FluentForm\Framework\Config;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FluentForm\Framework\Foundation\Provider;

class ConfigProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
    {
        $config = new Config(array('app' => $this->app->getAppConfig()));

        $this->app->bindInstance(
            'config', $config, 'Config', 'FluentForm\Framework\Config\Config'
        );
    }

    /**
     * The provider booted method to be called after booting
     * @return void
     */
    public function booted()
    {
        $this->loadConfig();
    }

    /**
     * Loads all configuration files from config directory
     * @return void
     */
	public function loadConfig()
    {
    	$files = [];
        $configPath = $this->app->configPath();
        $itr = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
            $configPath, RecursiveDirectoryIterator::SKIP_DOTS
        ));

        foreach($itr as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == "php" && $file->getFileName() != 'app.php') {
                $fileRealPath = $file->getRealPath();
                $directory = $this->getDirectory($file, $configPath);
                $this->app->config->set($directory.basename($fileRealPath, '.php'), include $fileRealPath);
            }
        }
    }

    /**
     * Get nested directory names joined by a "."
     * @param  string $file [A config file]
     * @param  string $configPath
     * @return string
     */
    protected function getDirectory($file, $configPath)
    {
        $ds = DIRECTORY_SEPARATOR;

        if ($directory = trim(str_replace(trim($configPath, '/'), '', $file->getPath()), $ds)) {
            $directory = str_replace($ds, '.', $directory).'.';
        }

        return $directory;
    }
}