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
        if (!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
    }
}
