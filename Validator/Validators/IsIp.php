<?php

namespace Validator\Validators;

use Validator\Pipable;

class IsIp implements Validatable,Pipable
{
    private $errorMsg;
    private $input;

    public function __construct(string $input, string $errorMsg)
    {
        $this->input = $input;
        $this->errorMsg = $errorMsg;
    }
    public function check(): string
    {
        if (filter_var($this->input, FILTER_VALIDATE_IP) == $this->input) {
            return '';
        }

        return $this->errorMsg;
    }
}
