<?php

namespace Router;

use Request\Request;
use MiddlewareHandler\Middleware as Middleware;

interface RouteInterface
{
    public function getRoute(): string;
    public function getVariables(): array;
    public function getMethod(): string;
    public function getAction();
    public function setVariables(array $values): void;
    public function setRequest(Request $request): void;
    public function bindMiddleware(string $middleware, bool $late): void;
    public function getMiddlewares(): array;
    public function getLateMiddlewares(): array;
}
