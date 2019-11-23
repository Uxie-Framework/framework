<?php

namespace Validator\Validators;

use Validator\Pipable;

class Length implements Validatable, Pipable
{
    private $input;
    private $errorMsg;
    private $max;
    private $min;

    public function __construct(string $input, int $min, int $max, string $errorMsg)
    {
        $this->input    = $input;
        $this->min      = $min;
        $this->max      = $max;
        $this->errorMsg = $errorMsg;
    }
    public function check(): string
    {
        if (!$this->maxLength($this->max) or !$this->minLength($this->min)) {
            return $this->errorMsg;
        }
        return '';
    }

    private function maxLength(int $max): bool
    {
        return (strlen($this->input) > $max) ? false : true;
    }

    private function minLength(int $min): bool
    {
        return (strlen($this->input) < $min) ? false : true;
    }
}
