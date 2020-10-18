<?php
namespace Validator;

use Validator\Validators\Validatable as Validatable;

class Pipeline
{
    private $validators = [];

    public function pipe(Validatable $validator): void
    {
        array_push($this->validators, $validator);
    }

    public function process(): array
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            if (!$validator->check()) {
                array_push($errors, $validator->getErrorMessage());
            }
        }

        return $errors;
    }
}
