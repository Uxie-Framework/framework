<?php

namespace Model;

use Exception;
use PDO;

abstract class Model
{
    protected static string $table = '';
    protected PDO $pdo;
    private string $query = '';
    private array $inputs = [];
    private string $whereFlag = 'where';

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                getenv('DB_CNX').':host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'),
                (string) getenv('DB_USER'),
                (string) getenv('DB_PASS')
            );
        } catch (\PDOException $e) {
            throw new Exception('cant connect to database '.$e->getMessage(), $e->getCode());
        }
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function query(string $query): \PDOStatement
    {
        try {
            $result = $this->pdo->query($query);
            return $result;
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    private function validateColumnName(string $column): void
    {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $column)) {
            throw new \Exception("Invalid column name: $column");
        }
    }

    private function execute(): \PDOStatement
    {
        $statement = $this->pdo->prepare($this->query);
        $verified = $statement->execute($this->inputs);
        $this->inputs = [];
        $this->query = '';
        $this->whereFlag = 'where';

        if (!$verified) {
            throw new Exception('Database query error', '0300');
        }

        return $statement;
    }

    public function get(): array
    {
        $statement = $this->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function first(): ?object
    {
        $data = $this->get();
        return $data[0] ?? null;
    }

    public function save(): \PDOStatement
    {
        return $this->execute();
    }

    public function count(): int
    {
        $statement = $this->execute();
        return $statement->rowCount();
    }

    public static function find(string $column, string $value): ?object
    {
        $data = static::select()->where($column, '=', $value)->get();
        return $data[0] ?? null;
    }

    public static function findOrFail(string $column, string $value): object
    {
        $data = static::select()->where($column, '=', $value)->get();

        if (empty($data)) {
            throw new \Exception("Record not found", 404);
        }

        return $data[0];
    }

    public static function increase(string $column, int|float $value): self
    {
        $instance = new static();
        $instance->validateColumnName($column);
        $instance->query = 'update '.static::$table." set `$column` = `$column` + $value";
        return $instance;
    }

    public static function decrease(string $column, int|float $value): self
    {
        $instance = new static();
        $instance->validateColumnName($column);
        $instance->query = 'update '.static::$table." set `$column` = `$column` - $value";
        return $instance;
    }

    public static function select(array $columns = ['*']): self
    {
        $instance = new static();
        foreach ($columns as $col) {
            if ($col !== '*') {
                $instance->validateColumnName($col);
            }
        }
        $instance->query = 'select '.implode($columns, ',').' from '.static::$table.' ';
        $instance->query .= 'where softdelete is false ';
        $instance->whereFlag = ' and ';
        return $instance;
    }

    public static function insert(array $data): self
    {
        $instance = new static();
        $data = array_merge($data, ['created_at' => date('Y-m-d H:i:s')]);
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));
        $instance->query .= 'insert into '.static::$table."($columns) values($values)";
        $instance->inputs = array_values($data);
        return $instance;
    }

    public static function update(array $data): self
    {
        $instance = new static();
        foreach (array_keys($data) as $col) {
            $instance->validateColumnName($col);
        }
        $columns = implode(',', array_map(function (string $value): string {
            return "$value = ?";
        }, array_keys($data)));
        $instance->query = 'update '.static::$table." set $columns ";
        $instance->inputs = array_values($data);
        return $instance;
    }

    public static function delete(): self
    {
        return static::update([
            'softdelete' => true,
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function hardDelete(): self
    {
        $instance = new static();
        $instance->query = 'delete from '.static::$table;
        return $instance;
    }

    public static function join(string $table, string $leftKey, string $rightKey): self
    {
        $instance = new static();
        $instance->validateColumnName($leftKey);
        $instance->validateColumnName($rightKey);
        $leftTable = static::$table;
        $instance->query = "select * from $leftTable join $table on $leftTable.$leftKey = $table.$rightKey where $leftTable.softdelete is false and $table.softdelete is false";
        $instance->whereFlag = ' and ';
        return $instance;
    }

    public static function leftJoin(string $table, string $leftKey, string $rightKey): self
    {
        $instance = new static();
        $instance->validateColumnName($leftKey);
        $instance->validateColumnName($rightKey);
        $leftTable = static::$table;
        $instance->query = "select * from $leftTable left join $table on $leftTable.$leftKey = $table.$rightKey where $leftTable.softdelete is false and $table.softdelete is false";
        $instance->whereFlag = ' and ';
        return $instance;
    }

    public function where(string $column, string $condition, string $input): self
    {
        $this->validateColumnName($column);
        $this->query .= ' '.$this->whereFlag." $column $condition ? ";
        $this->whereFlag = ' and ';
        $this->inputs[] = $input;
        return $this;
    }

    public function or(string $column, string $condition, string $input): self
    {
        $this->validateColumnName($column);
        $this->query .= " or $column $condition ? ";
        $this->inputs[] = $input;
        return $this;
    }

    public function groupBy(string $column): self
    {
        $this->validateColumnName($column);
        $this->query .= " group by $column ";
        return $this;
    }

    public function orderBy(string $column, string $order = 'desc'): self
    {
        $this->validateColumnName($column);
        if (!in_array(strtolower($order), ['asc', 'desc'])) {
            throw new \Exception("Invalid order direction: $order");
        }
        $this->query .= " order by $column $order ";
        return $this;
    }

    public function limit(int $offset, ?int $limit = null): self
    {
        $limitClause = ($limit !== null) ? ",$limit" : '';
        $this->query .= " limit $offset $limitClause";
        return $this;
    }
}
