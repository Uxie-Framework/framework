<?php

namespace Kernel\Compiler;

class MiddlewareCompiler implements DependencyCompilerInterface
{
    use \Services\Traits\Links;

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
        $middlewareProvider = require rootDir().$this->links['MiddlewaresProviders'];

        foreach ($this->middlewares as $middleware) {
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

        container()->build($middleware);
    }
}
