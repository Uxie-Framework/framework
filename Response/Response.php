<?php

namespace Response;

class Response
{
    private $response = '';
    private $flag     = false;

    private function addToResponse(string $text): void
    {
        if ($this->flag) {
            throw new \Exception("Response flag already raised, Response text already set", 1);
        }
        $this->response .= $text;
    }

    private function clearResponse()
    {
        $this->response = '';
    }

    private function printResponse(): void
    {
        if (!$this->response) {
            throw new \Exception("Can't overwright the response, The flag is raised", 1);
        }
        echo $this->Response;
    }

    private function raisFlag(): void
    {
        $this->flag = true;
    }

    public function write(string $text): Self
    {
        $this->addToResponse($text);
        return $this;
    }

    public function status(int $status): Self
    {
        http_response_code($status);
        return $this;
    }

    public function json(array $array): Self
    {
        $this->addToResponse(json_encode($array));
        return $this;
    }

    public function send(): Self
    {
        $this->printResponse();
        return $this;
    }

    public function end(): void
    {
        exit();
    }

    public function exception(string $message, int $code): \Exception
    {
        throw new \Exception($message, $code);
    }

    public function view(string $view, array $data = []): Self
    {
        $this->clearResponse();
        $this->addToResponse(view($view, $data));
        $this->raisFlag();
        return $this;
    }

    public function setCookie(string $name, string $value, string $expirationDate = null): void
    {
        cookie($name, $value, $expirationDate);
    }

    public function getCookie(string $name): string
    {
        return cookie($name);
    }

    public function unsetCookie(string $cookie): void
    {
        unsetCookie($cookie);
    }

    public function setSession(string $name, string $value = null): void
    {
        session($name, $value);
    }

    public function getSession(string $name): string
    {
        return session($name);
    }

    public function unsetSession(string $session): void
    {
        unsetSession($session);
    }

    public function unsetAllSessions(): void
    {
        session_destroy();
    }

    public function back(): void
    {
        redirect(previousUrl());
    }

    public function refresh(): void
    {
        redirect(currentUrl());
    }
}
