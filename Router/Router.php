<?php

namespace Router;

use Closure;
use Request\Request;

class Router implements RouterInterface
{
    private $route;
    private $routes;
    private $url;
    private $request;
    private $prefix = '';

    public function __construct(string $routesFile)
    {
        $this->routes = new RoutesCollection([]);
        $this->url = new Url;
        $this->request = container()->Request;
        $this->callRoutes($routesFile);

        if (isset($this->route)) {
            return $this;
        }

        throw new \Exception('This Page Does Not Exist', 404);
    }

    private function callRoutes(string $routesFile): void
    {
        require $routesFile;
    }

    public function get(string $route, $action): Router
    {
        return $this->addToRouteCollection(new Route('GET', $this->prefix, $route, $action));
    }

    public function post(string $route, $action): Router
    {
        return $this->addToRouteCollection(new Route('POST', $this->prefix, $route, $action));
    }

    public function put(string $route, $action): Router
    {
        return $this->addToRouteCollection(new Route('PUT', $this->prefix, $route, $action));
    }

    public function patch(string $route, $action): Router
    {
        return $this->addToRouteCollection(new Route('PATCH', $this->prefix, $route, $action));
    }

    public function delete(string $route, $action): Router
    {
        return $this->addToRouteCollection(new Route('DELETE', $this->prefix, $route, $action));
    }

    public function resource(string $route, string $controller): Router
    {
        $this->get($route, "$controller@index");
        $this->get("$route/create", "$controller@create");
        $this->post($route, "$controller@store");
        $this->get($route . '/{$id}', "$controller@show");
        $this->get($route . '/{$id}/edit', "$controller@edit");
        $this->put($route . '/{$id}', "$controller@update");
        $this->patch($route . '/{$id}', "$controller@update");
        $this->delete($route . '/{$id}', "$controller@delete");
        return $this;
    }

    public function group(string $prefix, Closure $action): Router
    {
        $this->prefix .= $prefix . '/';
        $action();
        $this->initialisePrefix();
        return $this;
    }

    public function middleware(string $middleware, bool $flag = false): Router
    {
        if (isset($this->route)) {
            $this->route->bindMiddleware($middleware, $flag);
        }
        return $this;
    }

    private function initialisePrefix(): void
    {
        $this->prefix = '';
    }

    private function addToRouteCollection(RouteInterface $route): Router
    {
        $this->routes->append($route);
        if ($this->routes->count() > 1) {
            $this->routes->next();
        }

        $this->ResolveRoute(new RouteResolver($route, $this->url, $this->request));

        return $this;
    }

    private function ResolveRoute(RouteResolver $resolver): void
    {
        if ($resolver->validate()) {
            $this->saveRoute();
            $this->bindRouteVariables($resolver->getUrlVariables());
            $this->bindRequest($this->request);
        }
    }

    private function saveRoute(): void
    {
        $this->route = isset($this->route) ? : $this->routes->current();
    }

    private function bindRouteVariables(array $variables): void
    {
        $this->route->setVariables($variables);
    }

    private function bindRequest(): void
    {
        $this->route->setRequest($this->request);
    }

    public function getRoute(): Route
    {
        return $this->route;
    }
}
