<?php

namespace Validator;

class validate
{
    private $input;
    private $errors = [];

    public function startValidation(string $input, string $field)
    {
        $this->input = $input;
        $this->field = $field;
        return $this;
    }

    public function isValide()
    {
        return empty($this->errors) ? true : false;
    }

    public function getErrors()
    {
        return empty($this->errors) ? [] : $this->generateErrorMessages(new ErrorMessageGenerator());
    }

    private function generateErrorMessages(ErrorMessageGeneratorInterface $generator)
    {
        foreach ($this->errors as $error) {
            $errorMessages[] = $generator->compileErrorMessage($error['validator'], $error['arguments']);
        }

        return $errorMessages;
    }

    public function __call($validator, $arguments)
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
