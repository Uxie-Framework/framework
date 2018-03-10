<?php

namespace Validator\Validators;

class Required extends Validator
{
    public function check(string $input)
    {
        return $input ? true : false;
    }
}
