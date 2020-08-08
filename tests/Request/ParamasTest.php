<?php

use PHPUnit\Framework\TestCase;
use Request\Params as Params;

class ParamsTest extends TestCase
{
    private $values;
    private $params;

    public function setUp(): void
    {
        $this->values = ['key1' => 'value1', 'key2' => 'value2'];
        $this->params = new Params($this->values);
    }
    public function testGetArray()
    {
        $this->assertIsArray(($this->params->getArray()), 'Params is not returning an Array');
    }

    public function testSetAndGet()
    {
        $this->params->key3 = 'value3';
        $this->assertEquals('value3', $this->params->key3, 'The key is returning the wrong value');
    }

    public function testIsSet()
    {
        $this->assertTrue(isset($this->params->key1), 'params value is not set');
    }
}
