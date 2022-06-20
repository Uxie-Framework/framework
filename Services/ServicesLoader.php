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
