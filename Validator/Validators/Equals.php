<?php

namespace Validator\Validators;

use Validator\Pipable;

class Equals implements Validatable, Pipable
{
    private $input;
    private $input2;
    private $errorMsg;

    public function __construct($input, $input2, string $errorMsg)
    {
        $this->input    = $input;
        $this->input2   = $input2;
        $this->errorMsg = $errorMsg;
    }
    public function check(): string
    {
        if ($this->input !== $this->input2) {
            return $this->errorMsg;
        }

        return '';
    }
}
