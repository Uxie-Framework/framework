<?php

namespace Request;

class Params
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

    public function __set($key, $value)
    {
        $this->variables[$key] = $value;
    }

    public function __get($key)
    {
        if (!isset($this->variables[$key])) {
            throw new \Exception("$key Param dont exist", 1);
        }
        return $this->variables[$key];
    }

    public function __isset($key)
    {
        return isset($this->variables[$key]) ? true : false;
    }
}
