<?php

namespace Response;

class Cookie
{
    public function get(string $key): string
    {
        return $_COOKIE[$key];
    }

    public function set(string $key, string $value, string $date): void
    {
        setcookie($key, $value, $date);
    }

    public function destroy(string $key): void
    {
        unset($_COOKIE[$key]);
    }

    public function destroyAll(): void
    {
        unset($_COOKIE);
    }

    public function __get(string $key): string
    {
        return $_COOKIE[$key];
    }

    public function __set(string $key, string $value): void
    {
        setcookie($key, $value);
    }

    public function __isset($key): bool
    {
        return isset($_COOKIE[$key]) ? true : false;
    }
}
