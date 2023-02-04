<?php

namespace Router;

use Request\Request;
use MiddlewareHandler\Middleware as Middleware;

interface RouteInterface
{
    public function getRoute(): string;
    public function getMethod(): string;
    public function getAction();
    public function bindMiddleware(string $middleware, bool $late): void;
    public function getMiddlewares(): array;
    public function getLateMiddlewares(): array;
}
