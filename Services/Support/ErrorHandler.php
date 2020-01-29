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
        if (getenv('PRODUCTION_MODE') === 'ON') {
            $this->response->view('CoreViews/error', ['code' => '404', 'error' => 'internal error'])->send();
        } else {
            $this->response->view('CoreViews/error', ['code' => $e->getCode(), 'error' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()])->send();
        }
    }
}
