<?php

namespace Model;

use Exception;

use PDO;

abstract class Model
{
    protected static $table = '';
    protected $pdo;
    protected static $query;
    protected static $inputs = [];
    protected static $whereFlag = 'where'; // this variable is to know if where method already called

    public function __construct()
    {
        try {
            $this->pdo = new PDO(getenv('DB_CNX').':host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
        } catch (PDOException $e) {
            throw new Exception('cant connect to database '.$e->getMessage(), $e->getCode());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function query($query)
    {
        try {
            $result = $this->pdo->query($query);

            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    private function execute()
    {
        $statment          = $this->pdo->prepare(static::$query);
        $verifyedStatment  = $statment->execute(static::$inputs);
        static::$inputs    = null;
        static::$query     = null;
        static::$whereFlag = 'where';

        if (!$verifyedStatment) {
            throw new Exception('Database query error', '0300');
        }

        return $statment;
    }

    public function get()
    {
        $statment = $this->execute();
        $data = $statment->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function first()
    {
        $statment = $this->execute();
        $data = $statment->fetchAll(PDO::FETCH_OBJ);

        return $data[0] ?? null;
    }

    public function save()
    {
        $statment = $this->execute();

        return $statment;
    }

    public function count()
    {
        $statment = $this->execute();

        return $statment->rowCount();
    }

    public static function find(string $column, string $value)
    {
        $data = static::select()->where($column, '=', $value)->get();

        return $data;
    }

    public static function findOrFail(string $column, string $value)
    {
        $exist = static::select()->where($column, '=', $value)->count();

        return boolval($exist);
    }

    public static function increase(string $column, string $value)
    {
        static::$query = 'update '.static::$table." set $column = ".$column.$value;

        return new static();
    }

    public static function select(array $columns = ['*'])
    {
        static::$query = 'select '.implode($columns, ',').' from '.static::$table.' ';
        static::$query .= 'where softdelete is false ';
        static::$whereFlag = ' and ';
        return new static();
    }

    public static function insert(array $data)
    {
        $data = array_merge($data, ['created_at' => date('Y-m-d H:i:s')]);
        $inputs = array_map('addslashes', array_values($data));
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($inputs), '?'));
        static::$query .= 'insert into '.static::$table."($columns) values($values)";
        static::$inputs = $inputs;

        return new static();
    }

    public static function update(array $data)
    {
        $inputs = array_map('addslashes', array_values($data));
        $columns = implode(',', array_map(function ($value) {
            return "$value = ?";
        }, array_keys($data)));
        $values = implode(',', array_fill(0, count($inputs), '?'));
        static::$query = 'update '.static::$table." set $columns ";
        static::$inputs = $inputs;

        return new static();
    }

    public static function delete()
    {
        static::update([
            'softdelete' => true,
            'deleted_at' => date('y-m-d H:i:s'),
        ]);

        return new static();
    }

    public static function hardDelete()
    {
        static::$query = 'delete from '.static::$table;

        return new static();
    }

    public function where(string $column, string $condition, string $input)
    {
        $input = addslashes($input);
        static::$query .= ' '.static::$whereFlag." $column $condition ? ";
        static::$whereFlag = ' and ';
        static::$inputs[] = $input;

        return $this;
    }

    public function or(string $column, string $condition, string $input)
    {
        static::$query .= " or $column $condition ? ";
        static::$inputs[] = $input;

        return $this;
    }

    public function groupBy(string $column)
    {
        static::$query .= " group by $column ";

        return $this;
    }

    public function orderBy(string $column, string $order = 'desc')
    {
        static::$query .= " order by $column $order ";

        return $this;
    }

    public function limit(int $limit, int $offset = null)
    {
        $offset = ($offset) ? ','.$offset : '';
        static::$query .= " limit $limit $offset";

        return $this;
    }
}
