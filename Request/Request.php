<?php

namespace Request;

use Validator\Validate;
use Exception;

class Request
{
    private array $variables = [];
    private string $method;
    private Validate $validator;
    public Body $body;
    public Files $files;
    public Params $params;

    public function __construct()
    {
        $this->handleData(new RequestDataHandler());
        $this->method = $this->resolveMethod(new RequestMethodResolver($this));
        $this->validator = new Validate();
    }

    private function resolveMethod(RequestMethodResolverInterface $resolver): string
    {
        return $resolver->getMethod();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function url(): string
    {
        $host = $_SERVER['HTTP_HOST'];
        $url  = $_SERVER['REQUEST_URI'];
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

    private function handleData(RequestDataHandler $handler): void
    {
        $this->body  = $handler->handleBody();
        $this->files = $handler->handleFiles();
    }

    public function validate(string $input, string $field): Validate
    {
        if (!isset($this->{$input})) {
            throw new Exception("( $input ) input does not exist", 1);
        }
        return $this->validator->startValidation($this->{$input}, $field);
    }

    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }

    public function __set(string $name, mixed $value): void
    {
        $this->variables[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        return $this->variables[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->variables[$name]);
    }
}
