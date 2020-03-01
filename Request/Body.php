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
        if (array_key_exists($key, $this->variables)) {
            return $this->variables[$key];
        }
        throw new \Exception("$key dont exist in Request", 1);
    }

    public function __isset($key)
    {
        return array_key_exists($key, $this->variables) ? true : false;
    }
}
