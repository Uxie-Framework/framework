<?php

namespace Validator\Validators;

class IsIp extends Validator
{
    public function check($input)
    {
        return filter_var($input, FILTER_VALIDATE_IP);
    }
}
