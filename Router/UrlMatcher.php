<?php

namespace Router;

class UrlMatcher implements UrlMatcherInterface
{
    private $url;
    private $route;
    public $urlVariables = [];

    public function __construct(Url $url, Route $route)
    {
        $this->url   = array_values($this->filterRoute(explode('/', $url->getUrl())));
        $this->route = array_values($this->filterRoute(explode('/', $route->getRoute())));
    }

    private function filterRoute(array $route)
    {
        $tmpArray = [];
        foreach ($route as $value) {
            if (strlen($value) > 0) {
                $tmpArray[] = $value;
            }
        }

        return $tmpArray;
    }

    public function matchURL(): bool
    {
        if (count($this->url) !== count($this->route)) {
            return false;
        }

        if (!$this->matchUrlWithRoute()) {
            return false;
        }

        return true;
    }

    private function matchUrlWithRoute(): bool
    {
        for ($i=0; $i < count($this->url); $i++) {
            if (($this->url[$i] !== $this->route[$i]) && !$this->isVariable($this->url[$i], $this->route[$i])) {
                return false;
            }
        }

        return true;
    }

    private function isVariable(string $urlVariable, string $routeVariable): bool
    {
        if (preg_match('@{\$(.*?)}@', $routeVariable)) {
            $this->urlVariables[$this->normalizeVariable($routeVariable)] = $urlVariable;
            return true;
        }

        return false;
    }

    private function normalizeVariable(string $variable)
    {
        preg_match('@{\$(.*?)}@', $variable, $result);
        return $result[1];
    }
}
