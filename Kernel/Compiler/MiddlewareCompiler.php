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

    public function execute()
    {
        $middlewareProvider = require rootDir().$this->links['MiddlewaresProviders'];

        foreach ($this->middlewares as $middleware) {
            $this->callMiddleware($middlewareProvider[$middleware]);
        }
    }

    private function callMiddleware(string $middleware)
    {
        if (!class_exists($middleware)) {
            throw new \Exception("$middleware Middleware can't be found", 26);
        }

        container()->build($middleware);
    }
}
