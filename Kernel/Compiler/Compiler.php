<?php

namespace Kernel\Compiler;

use Router\RouteInterface;

class Compiler
{

    /**
     * Call resolved action from a route
     *
     * @param RouteInterface $route
     */
    public function compileRoute(Routeinterface $route): void
    {
        $this->compile(new RouteCompiler($route));
    }

    /**
     * Call Middlewares attached to a route
     *
     * @param array $middlewares
     */
    public function compileMiddlewares(array $middlewares): void
    {
        $this->compile(new MiddlewareCompiler($middlewares));
    }

    /**
     * Call either a route action or a middleware
     *
     * @param DependencyCompilerInterface $dependencyCompiler
     */
    private function compile(DependencyCompilerInterface $dependencyCompiler): void
    {
        $dependencyCompiler->execute();
    }
}
