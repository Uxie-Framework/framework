<?php

namespace Validator\Validators;

class Equals extends Validator
{
    public function check(string $input, string $fieldName, string $match)
    {
        if ($input === $match) {
            return true;
        }

        return false;
    }
}
