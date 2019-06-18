<?php
namespace Cookie;

class Cookie
{
    private $cookies;

    public function __construct()
    {
        $this->cookies = $_COOKIE;
    }

    public function set(string $key, string $value, string $date): void
    {
        $this->cookies[$key] = $value;
        setcookie($key, $value, $date);
    }

    public function __get(string $key): string
    {
        if (isset($this->cookies[$key])) {
            return $this->cookies[$key];
        }

        throw new \Exception("$key does not exist in Cookie object", 1);
    }

    public function __isset(string $key): boolean
    {
        return isset($this->cookies[$key]);
    }
}
