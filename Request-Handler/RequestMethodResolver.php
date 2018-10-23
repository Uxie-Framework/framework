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

    public function getMethod()
    {
        if ($this->method === 'POST') {
            return $this->resolveMethodFromInputs();
        }
        return $this->method;
    }

    private function resolveMethodFromInputs()
    {
        if (isset($this->request->_method)) {
            return $this->getMethodFromRequest();
        }

        return 'POST';
    }

    private function getMethodFromRequest()
    {
        if (!in_array($this->request->_method, $this->allowedMethods)) {
            throw new \Exception($this->request->_method." Type of method is not supported", 1);
        }

        return $this->request->_method;
    }
}
