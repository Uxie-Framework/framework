<?php

use PHPUnit\Framework\TestCase;
use TestModel as TestModel;

require 'TestModel.php';
class ModelTest extends TestCase
{
    public function setUp()
    {
        putenv("DB_CNX=mysql");
        putenv("DB_HOST=127.0.0.1");
        putenv("DB_USER=root");
        putenv("DB_PASS=");
        putenv("DB_NAME=test");
        putenv("DB_PORT=3306");
        TestModel::query(
            "CREATE TABLE IF NOT EXISTS test (
                id VARCHAR(30) NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                date DATE,
                created_at DATE NOT NULL,
                deleted_at DATE,
                softdelete TINYINT(1) NOT NULL
            )"
        );
    }

    public function testInsert()
    {
        $test = TestModel::insert(['id' => uniqid(), 'date' => '2010-04-05','name' => 'myName'])->save();
        $this->assertInstanceof(\PDOStatement::class, $test);
    }

    public function testSelect()
    {
        $data = TestModel::select()->get();
        $this->assertTrue(is_array($data));
    }

    public function testCount()
    {
        $count = TestModel::select()->count();
        $this->assertTrue($count > 0);
    }

    public function testWhere()
    {
        $data = TestModel::select()->where('name', '=', 'myName')->count();
        $this->assertTrue($data > 0);
    }

    public function testFirst()
    {
        $data = TestModel::select()->first();
        $this->assertEquals($data->name, 'myName');
    }
}
