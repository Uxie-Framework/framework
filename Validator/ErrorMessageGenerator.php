<?php

namespace Validator;

class ErrorMessageGenerator implements ErrorMessageGeneratorInterface
{
    public function compileErrorMessage(string $validator, array $arguments)
    {
        $message = $this->getValidationErrorsByLanguage()[$validator];

        for ($i=0; $i < count($arguments); $i++) {
            $message = preg_replace("/\\$\\$/", $arguments[$i], $message, 1);
        }

        return $message;
    }

    private function getValidationErrorsByLanguage()
    {
        $validations = translation('Validations');

        return $validations[language()];
    }
}
