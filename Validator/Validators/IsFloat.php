<?php

namespace Validator\Validators;

use Validator\Pipable;

class IsFloat extends Validatable implements Pipable
{
    private $input;

    public function __construct(string $input, string $errorMsg)
    {
        $this->input    = $input;
        $this->errorMsg = $errorMsg;
    }

    public function check(): bool
    {
        if (!filter_var($this->input, FILTER_VALIDATE_FLOAT)) {
            return false;
        }

        return true;
    }
}
