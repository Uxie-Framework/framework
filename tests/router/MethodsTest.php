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
        try {
            $router = new Router\Router(__DIR__.'/routes.php');
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 900);
        }
    }

    public function testPut()
    {
        $_SERVER['REQUEST_URI'] = 'testPut';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'PUT';
        try {
            $router = new Router\Router(__DIR__.'/routes.php');
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 900);
        }
    }

    public function testPatch()
    {
        $_SERVER['REQUEST_URI'] = 'testPatch';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'PATCH';
        try {
            $router = new Router\Router(__DIR__.'/routes.php');
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 900);
        }
    }

    public function testDelete()
    {
        $_SERVER['REQUEST_URI'] = 'testDelete';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'DELETE';
        try {
            $router = new Router\Router(__DIR__.'/routes.php');
        } catch (\Exception $e) {
            $this->assertEquals($e->getCode(), 900);
        }
    }
}
