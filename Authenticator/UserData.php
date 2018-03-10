<?php

namespace Authenticator;

class UserData
{
    public function __get($key)
    {
        return session($key);
    }
}
