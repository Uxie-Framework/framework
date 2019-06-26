<?php

namespace Validator\Validators;

class Required implements Validatable
{
    private $input;
    private $errorMsg;

    public function __construct(string $input, string $errorMsg)
    {
        $this->input    = $input;
        $this->errorMsg = $errorMsg;
    }

    public function check(): string
    {
        if ($this->input) {
            return '';
        }

        return $this->errorMsg;
    }
}
