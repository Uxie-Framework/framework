<?php

use PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function setUp()
    {
        @session_start();
        IOC\IOC::createContainer();
        $_COOKIE['name'] = 'uxie';
        container()->bind('Response', function () {
            return new Response\Response();
        });
    }

    public function testGet()
    {
        $this->assertEquals(container()->Response->cookie->name, 'uxie');
        $this->assertEquals(container()->Response->cookie->get('name'), 'uxie');
    }
}
