<?php

use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function setUp()
    {
        IOC\IOC::createContainer();

        container()->bind('Response', function () {
            return new Response\Response();
        });
    }

    public function testWrite()
    {
        container()->Response->write('test');

        $imageReflection = new ReflectionClass(container()->Response);
        $property = $imageReflection->getProperty('response');
        $property->setAccessible(true);
        $response = $property->getValue(container()->Response);

        $this->assertEquals($response->getText(), 'test');
    }

    public function testStatus()
    {
        container()->Response->status(22);
        $this->assertEquals(http_response_code(), 22);
    }

    public function testJson()
    {
        container()->Response->json([
        'name' => 'uxie',
        'package' => 'response',
      ]);

        $imageReflection = new ReflectionClass(container()->Response);
        $property = $imageReflection->getProperty('response');
        $property->setAccessible(true);
        $response = $property->getValue(container()->Response);

        $this->assertEquals($response->getText(), '{"name":"uxie","package":"response"}');
    }
}
