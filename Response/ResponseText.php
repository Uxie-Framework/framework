<?php

namespace Response;

/**
 * This class represent the response text that will be sent back
 */
class ResponseText
{
    private $response = '';

    public function getText(): string
    {
        return $this->response;
    }

    public function writeResponse(): void
    {
        echo $this->response;
    }

    public function resetResponseTo(string $text): void
    {
        $this->response = $text;
    }

    public function resetResponse(): void
    {
        $this->response = '';
    }

    public function addToResponse(string $text): void
    {
        $this->response .= $text;
    }
}
