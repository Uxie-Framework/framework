<?php
namespace Response;

class Session
{
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): string
    {
        if (!isset($_SESSION[$key])) {
            throw new \Exception("$key does not exist in Session object", 1);
        }

        return $_SESSION[$key];
    }

    public function destroy(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroyAll(): void
    {
        session_destroy();
    }

    public function __get(string $key): string
    {
        if (!isset($_SESSION[$key])) {
            throw new \Exception("$key does not exist in Session object", 1);
        }

        return $_SESSION[$key];
    }

    public function __set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($_SESSION[$key]) ? true : false;
    }
}
