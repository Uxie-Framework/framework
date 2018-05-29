<?php

namespace Request;

class RequestDataHandler implements RequestDataHandlerInterface
{
    public function handle(): array
    {
        $variables = [];
        foreach ($_POST as $key => $value) {
            $variables[$key] = $this->filter($value);
        }

        return $variables;
    }

    private function filter($input)
    {
        if (is_string($input)) {
            return trim($input);
        }
        return null;
    }
}
