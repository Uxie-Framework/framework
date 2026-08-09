<?php

namespace Router;

class UrlMatcher implements UrlMatcherInterface
{
    private array $urlParts;
    private array $routeParts;
    private array $urlVariables = [];

    public function __construct(Url $url, Route $route)
    {
        $this->urlParts   = array_values($this->filterRoute(explode('/', $url->getUrl())));
        $this->routeParts = array_values($this->filterRoute(explode('/', $route->getRoute())));
    }

    public function getUrlVariables(): array
    {
        return $this->urlVariables;
    }

    private function filterRoute(array $segments): array
    {
        $filtered = [];
        foreach ($segments as $value) {
            if (strlen($value) > 0) {
                $filtered[] = $value;
            }
        }

        return $filtered;
    }

    public function matchURL(): bool
    {
        if (count($this->urlParts) !== count($this->routeParts)) {
            return false;
        }

        if (!$this->matchUrlWithRoute()) {
            return false;
        }

        return true;
    }

    private function matchUrlWithRoute(): bool
    {
        for ($i = 0; $i < count($this->urlParts); $i++) {
            if (($this->urlParts[$i] !== $this->routeParts[$i]) && !$this->isVariable($this->urlParts[$i], $this->routeParts[$i])) {
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
