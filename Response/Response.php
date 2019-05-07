<?php

namespace Response;

class Response
{
    public $session;
    public $cookie;
    private $response;

    public function __construct()
    {
        $this->response = new ResponseText();
        $this->session  = new Session();
        $this->cookie   = new Cookie();
    }

    public function write(string $text): Self
    {
        $this->response->addToResponse($text);
        return $this;
    }

    public function status(int $status): Self
    {
        http_response_code($status);
        return $this;
    }

    public function json(array $array, int $options = null): Self
    {
        $this->response->resetResponseTo(json_encode($array, $options));
        return $this;
    }

    public function send(): Self
    {
        $this->response->writeResponse();
        return $this;
    }

    public function end(): void
    {
        exit();
    }

    public function exception(string $message, int $code): \Exception
    {
        $this->response->resetResponse();
        throw new \Exception($message, $code);
    }

    public function view(string $view, array $data = []): Self
    {
        $this->response->resetResponseTo(view($view, $data));
        return $this;
    }

    public function back(): void
    {
        redirect(previousUrl());
    }

    public function refresh(): void
    {
        redirect(currentUrl());
    }

    public function redirect(string $url): void
    {
        redirect($url);
    }
}
