<?php

namespace Request;

class RequestDataHandler implements RequestDataHandlerInterface
{
    public function handle(): array
    {
        $variables = [];
        foreach ($_POST as $key => $value) {
            $variables[$key] = trim($value);
        }

        return $variables;
    }
}
