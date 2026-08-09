<?php

namespace Router;

use Request\Handler\Request;

class RouteResolver implements RouteResolverInterface
{
    private Route $route;
    private Url $url;
    private Request $request;
    private array $urlVariables = [];

    public function __construct(Route $route, Url $url, Request $request)
    {
        $this->route   = $route;
        $this->url     = $url;
        $this->request = $request;
    }

    public function validate(): bool
    {
        if (!$this->validateRequestMethod()) {
            return false;
        }

        if (!$this->urlMatchRoute(new UrlMatcher($this->url, $this->route))) {
            return false;
        }

        return true;
    }

    private function validateRequestMethod(): bool
    {
        return $this->route->getMethod() === $this->request->getMethod();
    }

    private function urlMatchRoute(UrlMatcher $matcher): bool
    {
        if ($matcher->matchURL()) {
            $this->setUrlVariables($matcher->getUrlVariables());
            return true;
        }

        return false;
    }

    private function setUrlVariables(array $urlVariables): void
    {
        $this->urlVariables = $urlVariables;
    }

    public function getUrlVariables(): array
    {
        return $this->urlVariables;
    }
}
