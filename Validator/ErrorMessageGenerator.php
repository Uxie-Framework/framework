<?php

namespace Validator;

class ErrorMessageGenerator implements ErrorMessageGeneratorInterface
{
    use \Services\Traits\Links;

    public function compileErrorMessage(string $validator, array $arguments)
    {
        $message = $this->getValidationErrors()[$validator];

        for ($i=0; $i < count($arguments); $i++) {
            $message = preg_replace("/\\$\\$/", $arguments[$i], $message, 1);
        }

        return $message;
    }

    private function getValidationErrors()
    {
        $validations = require rootDir().$this->links['validationLanguages'];
        $language = getLanguage() ?? 'default';

        return $validations[$language];
    }
}
