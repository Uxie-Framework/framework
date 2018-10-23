<?php

namespace Request;

use Validator\Validate;
use Exception;

class Request
{
    private $variables = [];
    private $method;

    public function __construct()
    {
        $this->handleData(new RequestDataHandler());
        $this->method    = $this->resolveMethod(new RequestMethodResolver($this));
        $this->validator = new Validate();
    }

    private function resolveMethod(RequestMethodResolverInterface $resolver)
    {
        return $resolver->getMethod();
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
        if (!isset($this->{$input})) {
            throw new \Exception("( $input ) input does not exist", 1);
        }
        return  $this->validator->startValidation($this->{$input}, $field);
    }

    public function isValide()
    {
        return (empty($this->getErrors())) ? true : false;
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
        return $this->variables[$name] ?? null;
    }

    public function __isset($name)
    {
        return isset($this->variables[$name]) ? true : false;
    }
}
