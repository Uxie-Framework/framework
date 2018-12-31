<?php

namespace Request;

class Body
{
    private $variables = [];

    public function __set($key, $value)
    {
        $this->variables[$key] = $value;
    }

    public function __get($key)
    {
        if (!isset($this->variables[$key])) {
            throw new \Exception("$key dont exist in Request", 1);
        }
        return $this->variables[$key];
    }

    public function __isset($key)
    {
        return isset($this->variables[$key]) ? true : false;
    }
}
