<?php


namespace App\Config;


use Symfony\Component\Config\FileLocator;

class Config implements IConfig
{
    private $config = [];
    private $loader;
    private $locator;

    public function __construct($dir)
    {
        $directories = [$dir];
        $this->setLocator($directories);
        $this->setLoader();
    }

    public function addConfig($file)
    {
        $configValues = $this->loader->load($this->locator->locate($file));
        if ($configValues) {
            foreach ($configValues as $key => $arr) {
                $this->config[$key] = $arr;
            }
        }
    }

    public function get($keyValue)
    {
        @list($key, $value) = explode('.', $keyValue);
        if ($key && isset($this->config[$key])) {
            if ($value && $this->config[$key][$value]) {
                return $this->config[$key][$value];
            } else {
                return $this->config[$key];
            }
        }
        return null;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return YamlConfigLoader
     */
    public function setLoader(): void
    {
        $this->loader = new YamlConfigLoader($this->locator);
    }

    /**
     * @param string $dir
     * @return FileLocator
     */
    public function setLocator($dir): void
    {
        $this->locator = new FileLocator($dir);
    }

}