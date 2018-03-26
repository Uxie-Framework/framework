<?php

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{

    public function setUp()
    {
        IOC\IOC::createContainer();
    }

    public function testGroup()
    {
        $_SERVER['REQUEST_URI'] = 'group/test';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function() {
            return new Request\Request();
        });
        $router = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testResource()
    {
        $_SERVER['REQUEST_URI'] = 'testResource';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function() {
            return new Request\Request();
        });
        $router = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertInstanceof(Router\Route::class, $router->getRoute());
    }

    public function testWrongUrl()
    {
        $_SERVER['REQUEST_URI'] = 'DontExist';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function() {
            return new Request\Request();
        });
        $this->expectException(\Exception::class);
        $router = new Router\Router(__DIR__.'/helpers/routes.php');
    }

    public function testPassedVariables()
    {
        $_SERVER['REQUEST_URI'] = 'variables/one/two';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function() {
            return new Request\Request();
        });
        $router = new Router\Router(__DIR__.'/helpers/routes.php');
        $this->assertEquals(['one', 'two'], $router->getRoute()->getVariables());
    }

    public function testUnpassedVariables()
    {
        $_SERVER['REQUEST_URI'] = 'variables/one/two/three';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        container()->bind('Request', function() {
            return new Request\Request();
        });
        $this->expectException(\Exception::class);
        $router = new Router\Router(__DIR__.'/helpers/routes.php');
    }
}
