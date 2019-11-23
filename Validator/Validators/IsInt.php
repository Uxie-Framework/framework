<?php

namespace Validator\Validators;

use Validator\Pipable;

class IsInt implements Validatable,Pipable
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
