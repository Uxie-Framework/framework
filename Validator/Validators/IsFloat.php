<?php

namespace Validator\validators;

class IsFloat implements Validatable
{
    private $input;
    private $errorMsg;

    public function __construct($input, string $errorMsg)
    {
        $this->input = $input;
        $this->errorMsg = $errorMsg;
    }

    public function check(): string
    {
        if (!is_float($this->input)) {
            return $this->errorMsg;
        }

        return '';
    }
}
