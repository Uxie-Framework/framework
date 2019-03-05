<?php

namespace Request;

use Validator\Validate as Validate;

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
        $this->validator = new Validate();
    }

    private function resolveMethod(RequestMethodResolverInterface $resolver): string
    {
        return $resolver->getMethod();
    }

    public function url(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function path(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function cookie(string $cookie): string
    {
        return cookie($cookie);
    }

    public function session(string $session): string
    {
        return session($session);
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

    public function validate(string $input, string $field): Validate
    {
        if (!isset($this->{$input})) {
            throw new \Exception("( $input ) input does not exist", 1);
        }
        return  $this->validator->startValidation($this->{$input}, $field);
    }

    public function isValide(): bool
    {
        return (empty($this->getErrors())) ? true : false;
    }

    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }
}
