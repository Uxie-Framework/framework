<?php

namespace Request;

use Validator\Validate;
use InvalidArgumentException;

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
        $this->method = (new RequestMethodResolver($this))->getMethod();
        $this->validator = new Validate();
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
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $url    = $_SERVER['REQUEST_URI'] ?? '/';
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        return "{$scheme}://{$host}{$url}";
    }

    public function path(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function cookie(string $cookie): mixed
    {
        return getCookie($cookie);
    }

    public function session(string $session): mixed
    {
        return getSession($session);
    }

    public function ip(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
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
            throw new InvalidArgumentException("Input '{$input}' does not exist");
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
        if (!isset($this->variables[$name])) {
            trigger_error("Undefined request property: {$name}", E_USER_WARNING);
        }
        return $this->variables[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->variables[$name]) || property_exists($this, $name);
    }
}
