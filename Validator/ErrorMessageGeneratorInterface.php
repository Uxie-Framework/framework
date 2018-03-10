<?php

namespace Validator;

interface ErrorMessageGeneratorInterface
{
    public function compileErrorMessage(string $validator, array $arguments);
}
