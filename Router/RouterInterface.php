<?php

namespace Router;

use Closure;

interface RouterInterface
{
    public function get(string $route, $action): Router;
    public function post(string $route, $action): Router;
    public function put(string $route, $action): Router;
    public function patch(string $route, $action): Router;
    public function delete(string $route, $action): Router;
    public function resource(string $route, string $controller): Router;
    public function group(string $prefix, Closure $action): Router;
    public function middleware(string $middleware, bool $flag): Router;
    public function getRoute(): Route;
}
