<?php

namespace Validator;

class Validator
{
    private $input;
    private $errors = [];

    public function validate(string $input, string $field): self
    {
        if (!isset(container()->Request->body->{$input})) {
            throw new \Exception("( $input ) input does not exist", 1);
        }

        return  $this->validator->startValidation(container()->request->body->{$input}, $field);
    }

    private function startValidation(string $input, string $field): self
    {
        $this->input = $input;
        $this->field = $field;
        return $this;
    }

    public function isValide(): bool
    {
        return empty($this->errors) ? true : false;
    }

    public function getErrors(): array
    {
        return empty($this->errors) ? [] : $this->generateErrorMessages(new ErrorMessageGenerator());
    }

    private function generateErrorMessages(ErrorMessageGeneratorInterface $generator): array
    {
        $errorMessages = [];
        foreach ($this->errors as $error) {
            $errorMessages[] = $generator->compileErrorMessage($error['validator'], $error['arguments']);
        }

        return $errorMessages;
    }

    public function __call($validator, $arguments): self
    {
        array_unshift($arguments, $this->input);
        if (!call_user_func_array(["Validator\Validators\\$validator", 'validate'], [$arguments])) {
            $arguments[0] = $this->field;
            $this->errors[] = [
                'validator' => $validator,
                'arguments' => $arguments,
            ];
        }

        return $this;
    }
}
