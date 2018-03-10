<?php

namespace Validator\Validators;

class Length extends Validator
{
    private $input;

    public function check(string $input, int $min, int $max)
    {
        $this->input = $input;
        if (!$this->maxLength($max) or !$this->minLength($min)) {
            return false;
        }
        return true;
    }

    private function maxLength(int $max)
    {
        return (strlen($this->input) > $max) ? false : true;
    }

    private function minLength(int $min)
    {
        return (strlen($this->input) < $min) ? false : true;
    }
}
