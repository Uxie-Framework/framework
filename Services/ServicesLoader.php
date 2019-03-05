<?php

namespace Services;

class ServicesLoader
{
    use Services;

    public function __construct()
    {
        $this->bindServicesToIOC();
        $this->loadApp();
        $this->loadServices();
    }

    private function bindServicesToIOC()
    {
        $this->bindedServices = array_merge_recursive($this->services, require rootDir().getAliase('Services'));
        array_map(array($this, 'checkForDuplication'), $this->bindedServices);
    }

    private function checkForDuplication(array $array)
    {
        array_map(array($this, 'checkIfUnique'), $array);
    }

    private function checkIfUnique(string $key)
    {
        if (isset(container()->{$key})) {
            throw new \Exception("There is a duplication in your Providers : $array[0]", 17);
        }
    }

    private function loadApp()
    {
        require rootDir().getAliase('App');
    }

    private function loadServices()
    {
        $this->loadLocators();
        $this->loadProviders();
    }

    private function loadLocators()
    {
        foreach ($this->bindedServices['ServiceLocators'] as $key => $value) {
            container()->register($key, $value);
        }
    }

    private function loadProviders()
    {
        foreach ($this->bindedServices['ServiceProviders'] as $value) {
            container()->build($value, container()->Request, container()->Response);
        }
    }
}
