<?php

namespace Kernel;

class Kernel implements KernelInterface
{
    /**
     * Prepare Application for launching
     * Load necessairy Services for the application to run
     *
     */
    public function prepare(): void
    {
        // load all service providers.
        container()->build('Services\ServicesLoader');
        // load env cinfiguration file.
        container()->Dotenv->load();
        // load the default configurations
        require_once rootDir().'defaults.php';
    }

    /**
     * Start the application
     * Call Middlewares
     *
     */
    public function start(): void
    {
        // call Middlewares
        container()->Compiler->compileMiddlewares(container()->Router->getRoute()->getMiddlewares());
        // execute application
        container()->Compiler->compileRoute(container()->Router->getRoute());
    }

    /**
     * This is the last method excuted during application life cycle
     * this method handle late Middleware
     *
     */
    public function stop(): void
    {
        container()->Compiler->compileMiddlewares(container()->Router->getRoute()->getLateMiddlewares());
    }
}
