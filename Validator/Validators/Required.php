<?php

namespace Validator\Validators;

use Validator\Pipable;

class Required extends Validatable implements Pipable
{
    private $input;

    public function __construct(string $input, string $errorMsg)
    {
        $this->input    = $input;
        $this->errorMsg = $errorMsg;
    }

    public function check(): bool
    {
        if (!$this->input) {
            return false;
        }

        return true;
    }
}
