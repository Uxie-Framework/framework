<?php

namespace Request;

use Validator\Validate;
use Exception;

class Request
{
    private $variables = [];
    private $errors = [];
    private $method;

    public function __construct()
    {
        $this->handleData(new RequestDataHandler());
        $this->method = (new RequestMethodResolver($this))->getMethod();
        $this->validator = new Validate();
    }

    public function getMethod()
    {
        return $this->method;
    }

    private function handleData(RequestDataHandler $handler)
    {
        $this->variables = $handler->handle();
    }

    public function validate(string $input, string $field)
    {
        return  $this->validator->startValidation($this->variables[$input], $field);
    }

    public function isValide()
    {
        return (empty($this->errors)) ? true : false;
    }

    public function getErrors()
    {
        return $this->validator->getErrors();
    }

    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function __get($name)
    {
        return $this->variables[$name];
    }

    public function __isset($name)
    {
        return isset($this->variables[$name]) ? $this->variables[$name] : false;
    }
}
