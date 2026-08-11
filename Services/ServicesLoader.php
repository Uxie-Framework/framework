<?php

namespace Services;

class ServicesLoader
{
    use Services;

    public function __construct()
    {
        $this->loadApp();
        $this->loadServices();
    }

    private function bindServicesToIOC(): void
    {
        $this->bindedServices = array_merge_recursive($this->services, require rootDir().getAliase('Services'));
        foreach ($this->bindedServices['ServiceLocators'] as $key => $value) {
            $this->checkIfUnique($key);
        }
    }

    private function checkIfUnique(string $key): void
    {
        if (isset(container()->{$key})) {
            throw new \Exception("There is a duplication in your Providers : $key", 17);
        }
    }

    private function loadApp()
    {
        require rootDir() . getAliase('App');
    }

    private function loadServices()
    {
        $this->loadLocators();
        $this->loadProviders();
    }

    private function loadLocators()
    {
        foreach ($this->services['ServiceLocators'] as $key => $value) {
            container()->register($key, $value);
        }
    }

    private function loadProviders()
    {
        foreach ($this->services['ServiceProviders'] as $value) {
            container()->build($value, container()->Request, container()->Response);
        }
    }
}
