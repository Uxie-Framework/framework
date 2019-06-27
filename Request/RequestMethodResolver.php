<?php

namespace Request;

class RequestMethodResolver implements RequestMethodResolverInterface
{
    private $request;
    private $method;
    private $allowedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->method  = $_SERVER['REQUEST_METHOD'];
    }

    public function getMethod(): string
    {
        if ($this->method === 'POST') {
            return $this->resolveMethodFromInputs();
        }
        
        return $this->method;
    }

    private function resolveMethodFromInputs(): string
    {
        if (isset($this->request->body->_method)) {
            return $this->getMethodFromRequest();
        }

        return 'POST';
    }

    private function getMethodFromRequest(): string
    {
        if (!in_array($this->request->body->_method, $this->allowedMethods)) {
            throw new \Exception($this->request->body->_method." Type of method is not supported", 1);
        }

        return $this->request->body->_method;
    }
}
