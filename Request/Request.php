<?php

namespace Request;

class Request
{
    public $body;
    public $files;
    public $params;
    private $method;

    public function __construct()
    {
        $this->handleData(new RequestDataHandler());
        $this->method    = $this->resolveMethod(new RequestMethodResolver($this));
    }

    private function resolveMethod(RequestMethodResolverInterface $resolver): string
    {
        return $resolver->getMethod();
    }

    public function url(): string
    {
        $host = $_SERVER['HTTP_HOST'];
        $url = $_SERVER['REQUEST_URI'];
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$host$url";
    }

    public function path(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function cookie(string $cookie): string
    {
        return getCookie($cookie);
    }

    public function session(string $session): string
    {
        return getSession($session);
    }

    public function ip(): string
    {
        return $_SERVER['ip'];
    }

    public function setParams(array $params): void
    {
        $this->params = new Params($params);
    }

    public function method(): string
    {
        return $this->method;
    }

    private function handleData(RequestDataHandler $handler): void
    {
        $this->body  = $handler->handleBody();
        $this->files = $handler->handleFiles();
    }
}
