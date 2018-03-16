<?php

use PHPUnit\Framework\TestCase;

class MethodsTest extends TestCase
{
    public function testGet()
    {
        $_SERVER['REQUEST_URI'] = 'testGet';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $router = new Router\Router(__DIR__.'/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testPost()
    {
        $_SERVER['REQUEST_URI'] = 'testPost';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $router = new Router\Router(__DIR__.'/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());

    }

    public function testPut()
    {
        $_SERVER['REQUEST_URI'] = 'testPut';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'PUT';

        $router = new Router\Router(__DIR__.'/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testPatch()
    {
        $_SERVER['REQUEST_URI'] = 'testPatch';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'PATCH';

        $router = new Router\Router(__DIR__.'/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testDelete()
    {
        $_SERVER['REQUEST_URI'] = 'testDelete';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'DELETE';

        $router = new Router\Router(__DIR__.'/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }
}
