<?php

namespace Authenticator;

class Hash
{
    public static function hash(string $string)
    {
        return password_hash($string, PASSWORD_BCRYPT);
    }
}
