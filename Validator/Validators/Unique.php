<?php

namespace Validator\Validators;

class Unique extends Validatable
{
    private $input;
    private $model;
    private $column;
    private $errorMsg;

    public function __construct(string $input, string $model, string $column, string $errorMsg)
    {
        $this->input    = $input;
        $this->model    = $model;
        $this->column   = $column;
        $this->errorMsg = $errorMsg;
    }

    public function check(): string
    {
        $model = 'Model\\'.$model;
        $data = $model::select()->where($column, '=', $input)->get();

        if (empty($data)) {
            return '';
        }

        return $this->errorMsg;
    }
}
