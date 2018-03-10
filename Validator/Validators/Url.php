<?php

namespace Validator\Validators;

class Url extends Validator
{
    public function check(string $input)
    {
        return filter_var($input, FILTER_VALIDATE_URL);
    }
}
