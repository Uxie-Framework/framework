<?php

namespace Validator\Validators;

use Validator\Pipable;

class Unique implements Validatable, Pipable
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
        $data = $this->model::select()->where($this->column, '=', $this->input)->get();
        if (empty($data)) {
            return '';
        }

        return $this->errorMsg;
    }
}
