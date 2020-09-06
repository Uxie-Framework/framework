<?php

namespace Request;

class Body implements DataHolder
{
    private $variables = [];

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
        if (!array_key_exists($key, $this->variables)) {
            throw new \Exception("$key Param dont exist", 1);
        }
        return $this->variables[$key];
    }

    public function __isset(string $key): bool
    {
        return array_key_exists($key, $this->variables) ? true : false;
    }
}
