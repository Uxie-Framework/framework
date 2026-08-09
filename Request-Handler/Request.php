<?php

namespace Request\Handler;

use Request\Body;
use Request\Files;
use Request\Params;
use Request\RequestDataHandler;
use Request\RequestMethodResolver;
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
        $this->method = (new RequestMethodResolver($this))->getMethod();
        $this->validator = new Validate();
    }

    public function getMethod(): string
    {
        return $this->method;
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
        return  $this->validator->startValidation($this->{$input}, $field);
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
