<?php

namespace Services\Traits;

trait Aliases
{
    private static $aliases = [
        'App'                  => 'App/App.php',
        'MiddlewaresProviders' => 'App/MiddlewaresLocator.php',
        'Services'             => 'App/Services.php',
        'validationLanguages'  => '/resources/languages/Validations.php',
        'Controllers'          => 'App/Controllers',
        'Models'               => 'App/Models',
        'Middlewares'          => 'App/Middlewares',
    ];
}
