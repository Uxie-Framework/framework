<?php
namespace Session;

class Session
{
    public $sessions;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->sessions = $_SESSION;
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
        unset($this->sessions[$key]);
    }

    public function deleteAll(): void
    {
        session_destroy();
    }

    public function set(string $key, string $value): void
    {
        $this->sessions[$key] = $value;
        $_SESSION[$key] = $value;
    }

    public function __get($key): string
    {
        if (isset($this->sessions[$key])) {
            return $this->sessions[$key];
        }

        throw new \Exception("$key session does not exist in Session object", 1);
    }

    public function __isset(string $key): bool
    {
        return isset($this->sessions[$key]);
    }
}
