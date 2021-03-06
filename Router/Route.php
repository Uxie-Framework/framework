<?php

namespace Router;

use Request\Request;
use MiddlewareHandler\Middleware as Middleware;

class Route implements RouteInterface
{
    private $action;
    private $routeUrl;
    private $method;
    private $middlewares;
    private $lateMiddlewares;

    public function __construct(string $method, string $prefix, string $routeUrl, $action)
    {
        $this->method          = $method;
        $this->routeUrl        = $prefix.$routeUrl;
        $this->action          = $action;
        $this->middlewares     = new MiddlewaresCollection([]);
        $this->lateMiddlewares = new MiddlewaresCollection([]);
    }

    public function getRoute(): string
    {
        return $this->routeUrl;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function bindMiddleware(string $middleware, bool $late): void
    {
        if (!$late) {
            $this->middlewares->append($middleware);
        }
        if ($late) {
            $this->lateMiddlewares->append($middleware);
        }
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares->getArrayCopy();
    }

    public function getLateMiddlewares(): array
    {
        return $this->lateMiddlewares->getArrayCopy();
    }
}
