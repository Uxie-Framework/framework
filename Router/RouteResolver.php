<?php

namespace Router;

use Request\Request;

class RouteResolver implements RouteResolverInterface
{
    private $route;
    private $url;
    private $request;
    private $urlVariables = [];

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

        if (!$this->UrlMatchRoute(new UrlMatcher($this->url, $this->route))) {
            return false;
        }

        return true;
    }

    private function validateRequestMethod(): bool
    {
        if ($this->route->getMethod() === $this->request->method()) {
            return true;
        }

        return false;
    }

    private function UrlMatchRoute(UrlMatcher $matcher): bool
    {
        if ($matcher->match()) {
            $this->setUrlVariables($matcher->urlVariables);
            return true;
        }

        return false;
    }

    private function setUrlVariables($urlVariables): void
    {
        $this->urlVariables = $urlVariables;
    }

    public function getUrlVariables(): array
    {
        return $this->urlVariables;
    }
}
