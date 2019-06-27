<?php

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = 'PUT';
        $request = new Request\Request();
        $this->assertEquals('PUT', $request->method());
        
        $_POST['_method'] = 'DELETE';
        $request = new Request\Request();
        $this->assertEquals('DELETE', $request->method());
    }

    public function testUrl()
    {
        $_SERVER['REQUEST_URI'] = 'url';
        $request = new Request\Request();
        $this->assertEquals('http://url', $request->url());
    }

    public function testPath()
    {
        $_SERVER['REQUEST_URI'] = 'url';
        $request = new Request\Request();
        $this->assertEquals('url', $request->path());
    }

    public function testIp()
    {
        $_SERVER['ip'] = '127.0.0.1';
        $request = new Request\Request();
        $this->assertEquals('127.0.0.1', $request->ip());
    }
}
