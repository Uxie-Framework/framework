<?php

namespace Request;

class RequestDataHandler implements RequestDataHandlerInterface
{
    private $body;

    public function __construct()
    {
        $this->body  = new Body();
        $this->files = new Files();
    }

    public function handleBody(): Body
    {
        foreach ($_POST as $key => $value) {
            $this->body->key = $this->filter($value);
        }

        return $this->body;
    }

    public function handleFiles()
    {
        foreach ($_FILES as $key => $value) {
            $this->files->{$key} = $this->normalizeFilesData($value);
        }
    }

    public function normalizeFilesData(array $data): array
    {
        if (count($_FILES < 2)) {
            return $data;
        }

        $result = [];
        foreach ($data as $key => $value) {
            foreach ($variable as $key2 => $value2) {
                $result[$key2][$key] = $value2;
            }
        }

        return $result;
    }

    private function filter($input)
    {
        if (is_string($input)) {
            return trim($input);
        }
        return null;
    }
}
