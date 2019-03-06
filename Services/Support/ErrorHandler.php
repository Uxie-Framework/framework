<?php
namespace Services\Support;

use Request\Request as Request;
use Response\Response as Response;

class ErrorHandler
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    public function handle(\Throwable $e)
    {
        container()->Logger->error($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
        $code = $e->getCode();
        $error = $e->getMessage();
        if (getenv('PRODUCTION_MODE') === 'ON') {
            $code = 'ERROR';
            $error = '404';
        }
        $this->response->view('CoreViews/error', ['code' => $code, 'error' => $error])->send();
    }
}
