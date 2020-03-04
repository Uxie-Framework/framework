<?php

namespace Services\Traits;

trait Aliases
{
    private static $aliases = [
        'App'                  => 'App/App.php',
        'MiddlewaresProviders' => 'App/MiddlewaresLocator.php',
        'Controllers'          => 'App/Controllers',
        'Filters'              => 'App/Filters',
        'Models'               => 'App/Models',
        'Repositories'         => 'App/Repositories',
        'Middlewares'          => 'App/Middlewares',
        'ServicesFolder'       => 'App/Services',
    ];
}
