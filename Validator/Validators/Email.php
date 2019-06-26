<?php

namespace Validator\Validators;

class Email implements Validatable
{
    private $input;
    private $errorMsg;

    public function __construct(string $input, string $errorMsg)
    {
        $this->input = $input;
        $this->errorMsg = $errorMsg;
    }

    public function check(): string
    {
        if (!filter_var($this->input, FILTER_VALIDATE_EMAIL)) {
            return $this->errorMsg;
        }

        return '';
    }
}
