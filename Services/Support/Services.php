<?php

namespace Services\Support;

trait Services
{
    private $services = [

        'ServiceLocators' => [
            'Router'     => \Router\Router::class,
            'Kernel'     => \Kernel\Kernel::class,
            'Compiler'   => \Kernel\Compiler\Compiler::class,
            'Middleware' => \App\Middleware\Middleware::class,
            'Dotenv'     => \Dotenv\Dotenv::class,
            'Blade'      => \Jenssegers\Blade\Blade::class,
            'Pug'        => \Pug\Pug::class,
            'Auth'       => \Authenticator\Auth::class,
        ],

        'ServiceProviders' => [
            \Services\ErrorHandler::class,
            \Services\Logger::class,
        ],
    ];
}
