<?php

namespace Router;

use Closure;
use Request\Handler\Request;

class Route implements RouteInterface
{
    private string|Closure $action;
    private array $variables = [];
    private string $routeUrl;
    private string $method;
    private Request $request;
    private MiddlewaresCollection $middlewares;
    private MiddlewaresCollection $lateMiddlewares;

    public function __construct(string $method, string $prefix, string $routeUrl, string|Closure $action)
    {
        $this->method          = $method;
        $this->routeUrl        = $prefix . $routeUrl;
        $this->action          = $action;
        $this->middlewares     = new MiddlewaresCollection([]);
        $this->lateMiddlewares = new MiddlewaresCollection([]);
    }

    public function getRoute(): string
    {
        return $this->routeUrl;
    }

    public function getVariables(): array
    {
        return $this->variables;
    }

    public function getAction(): string|Closure
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

    public function setVariables(array $values): void
    {
        $this->variables = $values;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
