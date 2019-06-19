<?php
namespace Cookie;

class Cookie
{
    private $cookies;

    public function __construct()
    {
        $this->cookies = $_COOKIE;
    }

    public function delete(string $key): void
    {
        unset($_COOKIE[$key]);
        setcookie($key, '', time()-1);
    }

    public function deleteAll(): void
    {
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, $value, time()-1);
        }
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
