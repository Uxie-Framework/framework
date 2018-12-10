<?php

namespace Request;

class RequestDataHandler implements RequestDataHandlerInterface
{
    private $body;

    public function __construct()
    {
        $this->body = new Body();
    }

    public function handle(): Body
    {
        foreach ($_POST as $key => $value) {
            $this->body->key = $this->filter($value);
        }

        return $this->body;
    }

    private function filter($input)
    {
        if (is_string($input)) {
            return trim($input);
        }
        return null;
    }
}
