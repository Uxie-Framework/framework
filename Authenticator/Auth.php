<?php

namespace Authenticator;

class Auth
{
    public static function check(?array $conditions = null): bool
    {
        $check = new Check();
        if (!empty($conditions)) {
            return $check->checkif($conditions);
        }
        return $check->check();
    }

    public static function user(): UserData
    {
        return new UserData();
    }

    public static function attempt(array $data): bool
    {
        $attempt = new Attempt($data);
        return $attempt->login();
    }

    public static function hash(string $string): string
    {
        return Hash::hash($string);
    }

    public static function logout(): void
    {
        new Logout();
    }
}
