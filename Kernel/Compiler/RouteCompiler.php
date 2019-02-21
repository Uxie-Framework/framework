<?php

namespace Kernel\Compiler;

use Router\RouteInterface;
use Closure;

class RouteCompiler implements DependencyCompilerInterface
{
    private $route;
    private $arguments;

    public function __construct(RouteInterface $route)
    {
        $this->route = $route;
        $this->arguments = [
          container()->Request,
          container()->Response,
        ];
    }

    /**
     * Check if route action is Closure or method@controller format
     * And then call it
     *
     * @return Mixed
     */
    public function execute()
    {
        if ($this->route->getAction() instanceof Closure) {
            return $this->callClosure($this->route);
        }

        if ($this->isController($this->route)) {
            return $this->executeController($this->route);
        }

        throw new \Exception('Route Parameter Error', 1);
    }

    /**
     * Check if route action is a Closure then excute it.
     *
     * @param RouteInterface $route
     */
    private function callClosure(RouteInterface $route): void
    {
        $action = $route->getAction();
        $action(...$this->arguments);
    }

    /**
     * Call method from controller if it's a valide controller.
     *
     * @param RouteInterface $route
     * @return bool
     */
    private function isController(RouteInterface $route)
    {
        // check if route is in Class@method format.
        if (strpos($route->getAction(), '@') && !strpos($route->getAction(), '/')) {
            return true;
        }

        return false;
    }

    /**
     * Create Controller instance and call the right method
     *
     * @param RouteInterface $route
     * @return object
     */
    private function executeController(RouteInterface $route)
    {
        $parameters = $this->explodeController($route);
        $controller = new $parameters['controller'](container()->Request, container()->Response);
        return call_user_func_array([$controller, $parameters['method']], $this->arguments);
    }

    /**
     * Resolve Controller name and method to call
     *
     * @param RouteInterface $route
     * @return array
     */
    private function explodeController(RouteInterface $route): array
    {
        $parameters = explode('@', $route->getAction());
        return [
            'controller' => '\Controller\\'.$parameters[0],
            'method' => $parameters[1],
        ];
    }
}
