<?php

namespace Box\Templates;

trait Repository
{
    public function template(string $directory, string $fileName, string $flag = null)
    {
        return
'<?php
namespace Repository'.$directory.';

use Model\\'.$flag.' as Model;
use Request\Request as Request;
use Response\Response as Response;

class '.$fileName.'
{
    private $model;

    public function __construct()
    {
        $this->model = new Model;
    }
}';
    }
}
