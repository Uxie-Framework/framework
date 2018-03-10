<?php

namespace Validator\validators;

class IsFloat extends Validator
{
    public function check($input)
    {
        return filter_var($input, FILTER_VALIDATE_FLOAT);
    }
}
