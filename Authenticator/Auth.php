<?php

namespace Authenticator;

class Auth
{
    public static function check(array $conditions = null)
    {
        $check = new Check();
        if (!empty($conditions)) {
            return $check->checkif($conditions);
        }
        return $check->check();
    }

    public static function user()
    {
        return new UserData();
    }

    public static function attempt(array $data)
    {
        $attempt = new Attempt($data);
        return $attempt->login();
    }

    public static function hash(string $string)
    {
        return Hash::hash($string);
    }

    public static function logout()
    {
        new Logout();
    }
}
