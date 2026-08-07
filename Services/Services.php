<?php

namespace Services;

trait Services
{
    private $services = [

        'ServiceLocators' => [
            'Router'     => \Router\Router::class,
            'Kernel'     => \Kernel\Kernel::class,
            'Compiler'   => \Kernel\Compiler\Compiler::class,
            'Dotenv'     => \Dotenv\Dotenv::class,
            'Blade'      => \Jenssegers\Blade\Blade::class,
            'Auth'       => \Authenticator\Auth::class,
        ],

        'ServiceProviders' => [
            \Services\Support\ErrorHandler::class,
            \Services\Support\Logger::class,
        ],
    ];
}
