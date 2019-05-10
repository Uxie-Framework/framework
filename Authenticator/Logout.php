<?php

namespace Authenticator;

class Logout
{
    public function __construct()
    {
        $this->logout();
    }

    private function logout()
    {
        destroyAllSessions();
    }
}
