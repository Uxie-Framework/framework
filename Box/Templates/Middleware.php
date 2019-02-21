<?php

namespace Box\Templates;

use Request\Request as Request;
use Response\Response as Response;

trait Middleware
{
    public function template(string $directory, string $fileName, string $flag = null)
    {
        return '<?php

namespace Middleware'.$directory.';

class '.$fileName.'
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
}
