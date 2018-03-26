<?php

use PHPUnit\Framework\TestCase;

class MethodsTest extends TestCase
{
    public function setUp()
    {
        IOC\IOC::createContainer();
    }

    public function testGet()
    {
        $_SERVER['REQUEST_URI']    = 'testGet';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        container()->bind('Request', function() {
            return new Request\Request();
        });
        $router                    = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testPost()
    {
        $_SERVER['REQUEST_URI']    = 'testPost';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        container()->bind('Request', function() {
            return new Request\Request();
        });
        $router                    = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());

    }

    public function testPut()
    {
        $_SERVER['REQUEST_URI']    = 'testPut';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method']          = 'PUT';

        container()->bind('Request', function() {
            return new Request\Request();
        });

        $router = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testPatch()
    {
        $_SERVER['REQUEST_URI']    = 'testPatch';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method']          = 'PATCH';

        container()->bind('Request', function() {
            return new Request\Request();
        });

        $router = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testDelete()
    {
        $_SERVER['REQUEST_URI']    = 'testDelete';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method']          = 'DELETE';

        container()->bind('Request', function() {
            return new Request\Request();
        });

        $router = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }
}
