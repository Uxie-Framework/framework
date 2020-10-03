<?php

namespace Request;

class Files
{
    private $variables = [];

    public function __set($key, $value): void
    {
        $this->variables[$key] = $value;
    }

    public function __get($key): string
    {
        return $this->variables[$key];
    }

    public function __isset($key): bool
    {
        return isset($this->variables[$key]) ? true : false;
    }
}
