<?php
namespace Validator;

interface Pipable
{
    public function check(): bool;
    public function getErrorMessage(): ?string;
}
