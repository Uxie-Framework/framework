<?php

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function setUp()
    {
        IOC\IOC::createContainer();
    }

    public function testGet()
    {
        $_SERVER['REQUEST_URI']    = 'testGet';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testPost()
    {
        $_SERVER['REQUEST_URI']    = 'testPost';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method']          = null;

        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testPut()
    {
        $_SERVER['REQUEST_URI']    = 'testPut';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method']          = 'PUT';

        container()->bind('Request', function () {
            return new Request\Request();
        });
        container()->bind('Response', function () {
            return new Response\Response();
        });

        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testPatch()
    {
        $_SERVER['REQUEST_URI']    = 'testPatch';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method']          = 'PATCH';

        container()->bind('Request', function () {
            return new Request\Request();
        });

        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testDelete()
    {
        $_SERVER['REQUEST_URI']    = 'testDelete';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method']          = 'DELETE';

        container()->bind('Request', function () {
            return new Request\Request();
        });

        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testGroup()
    {
        $_SERVER['REQUEST_URI']    = 'group/test';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_PORT']    = 80;
        $_SERVER['HTTP_HOST']      = 'localhost';
        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testResource()
    {
        $_SERVER['REQUEST_URI']    = 'testResource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testWrongUrl()
    {
        $_SERVER['REQUEST_URI']    = 'DontExist';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function () {
            return new Request\Request();
        });
        $this->expectException(\Exception::class);
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
    }

    public function testDefault()
    {
        $_SERVER['REQUEST_URI']    = 'DontExist';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function () {
            return new Request\Request();
        });

        $router = new Router\Router();
        $router->default(function () {
            echo 'hi';
        });
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testpassedVariables()
    {
        $_SERVER['REQUEST_URI']    = 'variables/one/two';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');

        $this->assertEquals('one', container()->Request->params->one);
        $this->assertEquals('two', container()->Request->params->two);
    }

    public function testUnpassedVariables()
    {
        $_SERVER['REQUEST_URI']    = 'variables/one/two/three';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function () {
            return new Request\Request();
        });
        $this->expectException(\Exception::class);
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
    }

    public function testGetRoute()
    {
        $_SERVER['REQUEST_URI']    = 'testGet';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $route = $router->getRoute();
        $this->assertInstanceof(Router\Route::class, $route);
    }

    public function testMiddleware()
    {
        $_SERVER['REQUEST_URI']    = 'testMiddleware';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertTrue(in_array('test', $router->getRoute()->getMiddlewares()));
    }

    public function testLateMiddlewares()
    {
        $_SERVER['REQUEST_URI']    = 'testLateMiddleware';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        container()->bind('Request', function () {
            return new Request\Request();
        });
        $router = new Router\Router();
        $router->call(__DIR__.'/helpers/routes.php');
        $this->assertTrue(in_array('test', $router->getRoute()->getLateMiddlewares()));
    }
}
