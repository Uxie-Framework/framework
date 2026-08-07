<?php

namespace Request;

class RequestDataHandler implements RequestDataHandlerInterface
{
    private $body;
    private $files;

    public function __construct()
    {
        $this->body  = new Body();
        $this->files = new Files();
    }

    public function handleBody(): Body
    {
        foreach ($_POST as $key => $value) {
            $this->body->{$key} = $value;
        }

        return $this->body;
    }

    public function handleFiles(): Files
    {
        foreach ($_FILES as $key => $value) {
            $this->files->{$key} = $this->normalizeFilesData($value);
        }

        return $this->files;
    }

    public function normalizeFilesData(array $data): array
    {
        if (count($_FILES) < 2) {
            return $data;
        }

        $result = [];
        foreach ($data as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $result[$key2][$key] = $value2;
            }
        }

        return $result;
    }
}
