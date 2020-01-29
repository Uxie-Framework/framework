<?php

namespace Box\Templates;

trait Filter
{
    public function template(string $directory, string $fileName, string $flag = null)
    {
        return '<?php

namespace Filter'.$directory.';

use Request\Request as Request;
use Validate\Validator as Validator;
use Filter\Filterable as Filterable;

class '.$fileName.' extends Validator implements Filterable
{

    public function __construct(Request $request)
    {
        parent::__construct();
    }

    public function check(): bool
    {
        if ($this->isValide()) {
            return true;
        }

        return false;
    }
}';
    }
}
