<?php

namespace Box\Templates;

trait Controller
{
    public function template(string $directory, string $fileName, string $flag = null)
    {
        if ($flag === '-r') {
            return $this->resourceController($directory, $fileName);
        }

        return $this->emptyController($directory, $fileName);
    }

    public function emptyController(string $directory, string $fileName)
    {
        return '<?php

namespace Controller'.$directory.';

use Controller\Controller as Controller;
use Request\Request as Request;
use Response\Response as Response;

class '.$fileName.' extends Controller
{
    private $response;
    private $request;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request  = $request;
    }
}';
    }

    public function resourceController(string $directory, string $fileName)
    {
        return '<?php

namespace Controller'.$directory.';

use Controller\Controller as Controller;
use Request\Request as Request;
use Response\Response as Response;

class '.$fileName.' extends Controller
{
    private $response;
    private $request;
    
    pubic function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request  = $request;
    }

    public function index(Request $request, Response $response)
    {
        //
    }

    public function create(Request $request, Response $response)
    {
        //
    }

    public function store(Request $request, Response $response)
    {
        //
    }

    public function show(Request $request, Response $response)
    {
        //
    }

    public function edit(Request $request, Response $response)
    {
        //
    }

    public function update(Request $request, Response $response)
    {
        //
    }

    public function delete(Request $request, Response $response)
    {
        //
    }
}';
    }
}
