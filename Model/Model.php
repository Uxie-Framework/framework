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

    public function getPDO(): \PDO
    {
        return $this->pdo;
    }

    public function query($query): \PDOStatement
    {
        try {
            $result = $this->pdo->query($query);

            return $result;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    private function execute(): bool
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

    public function get(): array
    {
        $statment = $this->execute();
        $data = $statment->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function first(): object
    {
        $statment = $this->execute();
        $data = $statment->fetchAll(PDO::FETCH_OBJ);

        return $data[0] ?? null;
    }

    public function save(): bool
    {
        $statment = $this->execute();

        return $statment;
    }

    public function count(): int
    {
        $statment = $this->execute();

        return $statment->rowCount();
    }

    public static function find(string $column, string $value): array
    {
        $data = static::select()->where($column, '=', $value)->get();

        return $data;
    }

    public static function findOrFail(string $column, string $value): bool
    {
        $exist = static::select()->where($column, '=', $value)->count();

        return boolval($exist);
    }

    public static function increase(string $column, string $value): self
    {
        static::$query = 'update '.static::$table." set $column = ".$column.$value;

        return new static();
    }

    public static function select(array $columns = ['*']): self
    {
        static::$query = 'select '.implode($columns, ',').' from '.static::$table.' ';
        static::$query .= 'where softdelete is false ';
        static::$whereFlag = ' and ';
        return new static();
    }

    public static function insert(array $data): self
    {
        $data = array_merge($data, ['created_at' => date('Y-m-d H:i:s')]);
        $inputs = array_map('addslashes', array_values($data));
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($inputs), '?'));
        static::$query .= 'insert into '.static::$table."($columns) values($values)";
        static::$inputs = $inputs;

        return new static();
    }

    public static function update(array $data): self
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

    public static function delete(): self
    {
        static::update([
            'softdelete' => true,
            'deleted_at' => date('y-m-d H:i:s'),
        ]);

        return new static();
    }

    public static function hardDelete(): self
    {
        static::$query = 'delete from '.static::$table;

        return new static();
    }

    public static function join(string $table, string $leftKey, string $rightKey): self
    {
        $leftTable = static::$table;
        $rightTable = $table;
        static::$query = "select * from $leftTable join $rightTable on $leftTable.$leftKey = $rightTable.$rightKey where $leftTable.softdelete is false and $rightTable.softdelete is false";
        static::$whereFlag = ' and ';
        return new static();
    }

    public static function leftJoin(string $table, string $leftKey, string $rightKey): self
    {
        $leftTable = static::$table;
        $rightTable = $table;
        static::$query = "select * from $leftTable left join $rightTable on $leftTable.$leftKey = $rightTable.$rightKey where $leftTable.softdelete is false and $rightTable.softdelete is false";
        static::$whereFlag = ' and ';
        return new static();
    }

    public function where(string $column, string $condition, string $input): self
    {
        $input = addslashes($input);
        static::$query .= ' '.static::$whereFlag." $column $condition ? ";
        static::$whereFlag = ' and ';
        static::$inputs[] = $input;

        return $this;
    }

    public function or(string $column, string $condition, string $input): self
    {
        static::$query .= " or $column $condition ? ";
        static::$inputs[] = $input;

        return $this;
    }

    public function groupBy(string $column): self
    {
        static::$query .= " group by $column ";

        return $this;
    }

    public function orderBy(string $column, string $order = 'desc'): self
    {
        static::$query .= " order by $column $order ";

        return $this;
    }

    public function limit(int $offset, int $limit = null): self
    {
        $limit = ($limit) ? ','.$limit : '';
        static::$query .= " limit $offset $limit";
        return $this;
    }
}
