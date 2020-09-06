<?php

namespace Request;

class Params implements DataHolder
{
    private $variables = [];

    public function __construct(array $params)
    {
        $this->variables = $params;
    }

    public function getArray(): array
    {
        return $this->variables;
    }

    public function __set(string $key, ?string $value): void
    {
        $this->variables[$key] = $value;
    }

    public function __get(string $key): ?string
    {
        if (!isset($this->variables[$key])) {
            throw new \Exception("$key Param dont exist", 1);
        }
        return $this->variables[$key];
    }

    public function __isset(string $key): bool
    {
        return isset($this->variables[$key]) ? true : false;
    }
}
