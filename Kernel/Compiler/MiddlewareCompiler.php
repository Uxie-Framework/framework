<?php

namespace Kernel\Compiler;

class MiddlewareCompiler implements DependencyCompilerInterface
{
    private $middlewares;

    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * Call attached middlewares to route
     *
     */
    public function execute(): void
    {
        $middlewareProvider = require rootDir().getAliase('MiddlewaresProviders');

        foreach ($this->middlewares as $middleware) {
            if (!array_key_exists($middleware, $middlewareProvider)) {
                throw new \Exception("This middleware $middleware is not defined in the middleware locator");
            }

            $this->callMiddleware($middlewareProvider[$middleware]);
        }
    }

    /**
     * Create a Middleware instance
     *
     * @param string $middleware
     */
    private function callMiddleware(string $middleware): void
    {
        if (!class_exists($middleware)) {
            throw new \Exception("$middleware Middleware can't be found", 26);
        }

        container()->build($middleware, container()->Request, container()->Response);
    }
}
