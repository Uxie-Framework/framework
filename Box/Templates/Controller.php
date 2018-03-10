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
        return "<?php

namespace Controller".$directory.";

use Controller\Controller as Controller;

class ".$fileName." extends Controller
{
    public function welcom()
    {
        //
    }
} \n";
    }

    public function resourceController(string $directory, string $fileName)
    {
        return '<?php

namespace Controller'.$directory.';

use Controller\Controller as Controller;
use Request\Request as Request;

class '.$fileName.' extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function delete(Request $request, string $id)
    {
        //
    }
}';
    }
}
