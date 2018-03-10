<?php

namespace Box\Templates;

trait Middleware
{
    public function template(string $directory, string $fileName, string $flag = null)
    {
        return "<?php

namespace Middleware".$directory.";

class ".$fileName."
{
    public function __construct()
    {
        //
    }
} \n";
    }
}
