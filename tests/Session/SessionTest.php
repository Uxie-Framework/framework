<?php

use PHPUnit\Framework\TestCase;
use Session\Session as Session;

class SessionTest extends TestCase
{
    public function setUp()
    {
        @session_start();
        IOC\IOC::createContainer();
        $_SESSION['name'] = 'uxie';
        container()->bind('Session', function () {
            return new Session();
        });
    }

    public function testSet()
    {
        container()->Session->set('name', 'uxie');
        $this->assertEquals($_SESSION['name'], 'uxie');
    }

    public function testGet()
    {
        $this->assertEquals($_SESSION['name'], container()->Session->name);
    }
}
