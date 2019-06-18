<?php

use PHPUnit\Framework\TestCase;
use Cookie\Cookie as Cookie;

class CookieTest extends TestCase
{
    public function setUp()
    {
        IOC\IOC::createContainer();
        $_COOKIE['name'] = 'uxie';
        container()->bind('Cookie', function () {
            return new Cookie();
        });
    }

    public function testGet()
    {
        $this->assertEquals(container()->Cookie->name, $_COOKIE['name']);
    }
}
