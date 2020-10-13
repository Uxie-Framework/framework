<?php

namespace Validator\Validators;

use Validator\Pipable;

class IsInt extends Validatable implements Pipable
{
    private $input;

    public function __construct(string $input, string $errorMsg)
    {
        $this->input = $input;
        $this->errorMsg = $errorMsg;
    }

    public function check(): bool
    {
        if (!filter_var($this->input, FILTER_VALIDATE_INT)) {
            return false;
        }

        return true;
    }
}
