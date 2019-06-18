<?php
namespace Session;

class Session
{
    public $sessions;

    public function __construct()
    {
        $this->sessions = $_SESSION;
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

    public function __isset(string $key): boolean
    {
        return isset($this->sessions[$key]);
    }
}
