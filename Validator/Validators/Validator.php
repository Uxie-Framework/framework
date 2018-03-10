<?php

namespace Validator\Validators;

class Validator
{
    public static function validate(array $arguments)
    {
        $validator = new static();
        return $validator->check(...$arguments);
    }
}
