<?php

namespace Validator\Validators;

class Unique extends Validator
{
    public function check(string $input, string $model, string $column)
    {
        $model = 'Model\\'.$model;
        $data = $model::select()->where($column, '=', $input)->get();

        return (empty($data)) ? true : false;
    }
}
