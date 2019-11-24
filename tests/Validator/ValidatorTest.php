<?php

use PHPUnit\Framework\TestCase;
use Validator\Validator as Validator;

class ValidatorTest extends TestCase
{
    public function setUp()
    {
        tests\Model\TestModel::insert(['id' => uniqid(), 'date' => '20-04-05','name' => 'myName', 'count' => 1])->save();
    }

    public function testStart()
    {
        $this->assertInstanceof(Validator::class, Validator::start());
    }

    public function testValidate()
    {
        $validator = Validator::start();
        $this->assertInstanceof(Validator::class, $validator->validate());
    }

    public function testIsValide()
    {
        $validator = Validator::start();
        $this->assertTrue($validator->isValide());

        $imageReflection = new ReflectionClass($validator);
        $property        = $imageReflection->getProperty('errors');
        $property->setAccessible(true);
        $property->setValue($validator, ['error']);
        $this->assertFalse($validator->isValide());
    }

    public function testGetErrors()
    {
        $validator = Validator::start();
        $imageReflection = new ReflectionClass($validator);
        $property        = $imageReflection->getProperty('errors');
        $property->setAccessible(true);
        $property->setValue($validator, ['error']);
        $this->assertTrue(empty(array_diff(['error'], $validator->getErrors())));

        $property->setValue($validator, ['error', null]);
        $this->assertTrue(empty(array_diff(['error'], $validator->getErrors())));
    }

    public function testEmail()
    {
        $validator = Validator::start();
        $validator->email('email', 'not an email')->validate();
        $this->assertEquals('not an email', $validator->getErrors()[0]);

        $validator2 = Validator::start();
        $validator2->email('uxie@gmail.com', 'not an email')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testEquals()
    {
        $validator = Validator::start();
        $validator->equals(1, 2, 'Not Equals')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->equals(1, 1, 'Not Equals')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testIsFloat()
    {
        $validator = Validator::start();
        $validator->isFloat("5e", 'not a float')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->isFloat("2.5", 'not a float')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testIsInt()
    {
        $validator = Validator::start();
        $validator->isInt("5.58", 'error message')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->isInt("25", 'error message')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testIsIp()
    {
        $validator = Validator::start();
        $validator->isIp('34.44.322.3', 'error message')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->isIp('34.233.54.21', 'error message')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testLength()
    {
        $validator = Validator::start();
        $validator->length('name', 1, 3, 'error message')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->length('name', 1, 10, 'error message')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testRequired()
    {
        $validator = Validator::start();
        $validator->required('', 'error message')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->required('name', 'error message')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testUnique()
    {
        $validator = Validator::start();
        $validator->unique('myName', tests\Model\TestModel::class, 'name', 'Not Unique message error')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->unique('notMyName', tests\Model\TestModel::class, 'name', 'Not Unique message error')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }

    public function testUrl()
    {
        $validator = Validator::start();
        $validator->url('website', 'error message')->validate();
        $this->assertFalse(empty($validator->getErrors()));

        $validator2 = Validator::start();
        $validator2->url('http://google.com', 'error message')->validate();
        $this->assertTrue(empty($validator2->getErrors()));
    }
}
