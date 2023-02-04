<?php

namespace Box\Templates;

trait Model
{
    public function template(string $directory, string $fileName, string $flag = null)
    {
        return "<?php

namespace Model".$directory.";

use Model\Model;

class ".$fileName." extends Model
{
    protected static \$table = '".$fileName."s';
} \n";
    }
}
