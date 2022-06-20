<?php

namespace Validator\Validators;

abstract class Validatable
{
    protected $errorMsg;
    
    abstract public function check(): bool;
    
    public function getErrorMessage(): ?string
    {
        return $this->errorMsg;
    }
}
