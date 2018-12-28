<?php

namespace Response;

class Response
{
    private $response;

    public function write(string $text): Self
    {
        $this->response .= $text;
        return $this;
    }

    public function status(int $status): Self
    {
        http_response_code($status);
        return $this;
    }

    public function json(array $array): void
    {
        echo json_encode($array);
    }

    public function send(): Self
    {
        echo $this->response;
        return $this;
    }

    public function view(string $view): Self
    {
        view($view);
        return $this;
    }

    public function cookie(string $name, string $value, string $expirationDate): void
    {
        cookie($name, $value, $expirationDate);
    }

    public function clearCookies(string $cookie): void
    {
        unsetCookie($cookie);
    }

    public function session(string $name, string $value): void
    {
        session($name, $value);
    }

    public function clearSession(string $session): void
    {
        unsetSession($session);
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
