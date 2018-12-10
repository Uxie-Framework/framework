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
        return $this->variables[$key];
    }

    public function __isset($key)
    {
        return isset($this->variables[$key]) ? true : false;
    }
}
