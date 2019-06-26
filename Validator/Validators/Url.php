<?php

namespace Validator\Validators;

class Url implements Validatable
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
        if (filter_var($this->input, FILTER_VALIDATE_URL)) {
            return '';
        }

        return $this->errorMsg;
    }
}
