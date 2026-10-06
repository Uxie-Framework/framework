<?php

namespace Router;

use Closure;
use Request\Request;

interface RouteInterface
{
    public function getRoute(): string;
    public function getMethod(): string;
    public function getAction(): string|Closure;
    public function getVariables(): array;
    public function setVariables(array $values): void;
    public function setRequest(Request $request): void;
    public function bindMiddleware(string $middleware, bool $late): void;
    public function getMiddlewares(): array;
    public function getLateMiddlewares(): array;
}
