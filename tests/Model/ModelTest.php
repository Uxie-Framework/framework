<?php
namespace tests\Model;

use PHPUnit\Framework\TestCase;

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
                count INT(2) NOT NULL,
                created_at DATE NOT NULL,
                deleted_at DATE,
                softdelete TINYINT(1) NOT NULL
            )"
        );
    }

    public function testPdo()
    {
        $this->assertInstanceof(\PDO::class, TestModel::getPDO());
    }

    public function testQuery()
    {
        $this->assertInstanceof(\PDOStatement::class, TestModel::query('select * from test'));
    }

    public function testInsertAndSave()
    {
        $test = TestModel::insert(['id' => uniqid(), 'date' => '20-04-05','name' => 'myName', 'count' => 1])->save();
        $this->assertInstanceof(\PDOStatement::class, $test);

        $test = TestModel::insert(['id' => uniqid(), 'date' => '17-08-12', 'name' => 'hardDelete', 'count' => 1])->save();
        $this->assertInstanceof(\PDOStatement::class, $test);
    }

    public function testSelectAndGet()
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
        $data = TestModel::select()->where('name', '=', 'myName')->get();
        $this->assertTrue(is_array($data));
    }

    public function testOr()
    {
        $data = TestModel::select()->where('name', '=', 'Uxie')->or('name', '=', 'myName')->get();
        $this->assertEquals($data[0]->name, 'myName');
    }

    public function testFirst()
    {
        $data = TestModel::select()->first();
        $this->assertEquals($data->name, 'myName');
    }

    public function testUpdate()
    {
        $test = TestModel::update(['date' => '2020-04-05'])->where('name', '=', 'myName')->save();
        $this->assertInstanceof(\PDOStatement::class, $test);
    }

    public function testFind()
    {
        $test = TestModel::find('name', 'myName');
        $this->assertEquals($test[0]->name, 'myName');
    }

    public function testFindOrFail()
    {
        $this->assertTrue(TestModel::findOrFail('name', 'myName'));
        $this->assertFalse(TestModel::findOrFail('name', 'uxie'));
    }

    public function testIncrease()
    {
        $this->assertInstanceof(\PDOStatement::class, TestModel::increase('count', 1)->save());
    }

    public function testDecrease()
    {
        $this->assertInstanceof(\PDOStatement::class, TestModel::decrease('count', 1)->save());
    }

    public function testGroupBy()
    {
        $this->assertTrue(!empty(TestModel::select(['max(name)'])->groupBy('name')->get()));
    }

    public function testLimit()
    {
        $this->assertTrue(!empty(TestModel::select()->limit(1)->get()));
        $this->assertTrue(!empty(TestModel::select()->limit(1, 10)->get()));
    }

    public function testOrderBy()
    {
        $this->assertTrue(!empty(TestModel::select()->orderBy('name', 'ASC')->get()));
        $this->assertTrue(!empty(TestModel::select()->orderBy('name', 'DESC')->get()));
    }

    public function testHardDelete()
    {
        $this->assertInstanceof(\PDOStatement::class, TestModel::hardDelete()->where('name', '=', 'hardDelete')->save());
        $this->assertEquals(TestModel::select()->where('name', '=', 'hardDelete')->count(), 0);
    }

    public function testDelete()
    {
        $this->assertInstanceof(\PDOStatement::class, TestModel::delete()->where('name', '=', 'myName')->save());
        $this->assertTrue(empty(TestModel::select()->get()));
    }
}
