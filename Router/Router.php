<?php

namespace Router;

use Closure;
use Request\Handler\Request;

class Router implements RouterInterface
{
    private ?Route $route = null;
    private RoutesCollection $routes;
    private Url $url;
    private Request $request;
    private string $prefix = '';
    private Closure $defaultClosure;
    private bool $activeDefault = false;

    public function __construct()
    {
        $this->routes = new RoutesCollection([]);
        $this->url    = new Url;
    }

    /**
     * call routes from a given routes file.
     *
     * @param string $routesFile
     * @return Router
     */
    public function call(string $routesFile): Router
    {
        $this->request = container()->Request;
        $this->callRoutes($routesFile);

        if ($this->route !== null) {
            return $this;
        }

        if (!isset($this->route) && $this->activeDefault) {
            $this->route = new Route('DEFAULT', 'DEFAULT', 'DEFAULT', $this->defaultClosure);
            return $this;
        }

        throw new \Exception('This Page (' . url(currentUrl()) . ') Does Not Exist', 404);
    }

    /**
     * require a given file.
     *
     * @param string $routesFile
     */
    private function callRoutes(string $routesFile): void
    {
        $route = $this;
        require $routesFile;
    }

    public function any(string $route, $action): Router
    {
        return $this->addToRouteCollection(new Route('GET', $this->prefix, $route, $action))
            ->addToRouteCollection(new Route('POST', $this->prefix, $route, $action))
            ->addToRouteCollection(new Route('PUT', $this->prefix, $route, $action))
            ->addToRouteCollection(new Route('PATCH', $this->prefix, $route, $action))
            ->addToRouteCollection(new Route('DELETE', $this->prefix, $route, $action));
    }

    public function get(string $route, string|Closure $action): Router
    {
        return $this->addToRouteCollection(new Route('GET', $this->prefix, $route, $action));
    }

    public function post(string $route, string|Closure $action): Router
    {
        return $this->addToRouteCollection(new Route('POST', $this->prefix, $route, $action));
    }

    public function put(string $route, string|Closure $action): Router
    {
        return $this->addToRouteCollection(new Route('PUT', $this->prefix, $route, $action));
    }

    public function patch(string $route, string|Closure $action): Router
    {
        return $this->addToRouteCollection(new Route('PATCH', $this->prefix, $route, $action));
    }

    public function delete(string $route, string|Closure $action): Router
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
        $action($this);
        $this->initialisePrefix();
        return $this;
    }

    public function default(Closure $closure): void
    {
        $this->activeDefault  = true;
        $this->defaultClosure = $closure;
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
            container()->Request->setParams($resolver->getUrlVariables());
            $this->saveRoute();
        }
    }

    private function saveRoute(): void
    {
        $this->route = isset($this->route) ? $this->route : $this->routes->current();
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }
}
