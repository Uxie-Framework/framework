<?php
namespace Session;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): string
    {
        return $_SESSION[$key];
    }

    public function unsetSession(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function unsetAllSessions(): void
    {
        session_destroy();
    }
}
