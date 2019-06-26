<?php

namespace Validator\Validators;

class IsInt implements Validatable
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
        if (is_int($this->input)) {
            return '';
        }

        return $this->errorMsg;
    }
}
