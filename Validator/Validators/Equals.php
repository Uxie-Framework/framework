<?php

namespace Validator\Validators;

use Validator\Pipable;

class Equals extends Validatable implements Pipable
{
    private $input;
    private $input2;

    public function __construct(string $input, string $input2, string $errorMsg)
    {
        $this->input    = $input;
        $this->input2   = $input2;
        $this->errorMsg = $errorMsg;
    }

    public function check(): bool
    {
        if ($this->input !== $this->input2) {
            return false;
        }

        return true;
    }
}
