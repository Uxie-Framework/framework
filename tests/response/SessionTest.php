<?php

use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function setUp()
    {
        @session_start();
        IOC\IOC::createContainer();

        container()->bind('Response', function () {
            return new Response\Response();
        });
    }

    public function testSet()
    {
        container()->Response->session->set('name', 'uxie');
        $this->assertEquals($_SESSION['name'], 'uxie');
        container()->Response->session->name2 = 'uxie2';
        $this->assertEquals($_SESSION['name2'], 'uxie2');
    }

    public function testGet()
    {
        $_SESSION['name'] = 'uxie';
        $this->assertEquals($_SESSION['name'], container()->Response->session->get('name'));
        $this->assertEquals($_SESSION['name'], container()->Response->session->name);
    }
}
