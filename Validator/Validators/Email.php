<?php

namespace Validator\Validators;

class Email extends Validator
{
    public function check(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
