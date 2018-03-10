<?php

namespace Validator\Validators;

class IsInt extends Validator
{
    public function check($input)
    {
        return filter_var($input, FILTER_VALIDATE_INT);
    }
}
