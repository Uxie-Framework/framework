<?php

namespace Validator\Validators;

use Validator\Pipable;

class Email implements Validatable, Pipable
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
