<?php

namespace Validator\Validators;

use Validator\Pipable;

class Unique extends Validatable implements Pipable
{
    private $input;
    private $model;
    private $column;

    public function __construct(string $input, string $model, string $column, string $errorMsg)
    {
        $this->input    = $input;
        $this->model    = $model;
        $this->column   = $column;
        $this->errorMsg = $errorMsg;
    }

    public function check(): bool
    {
        $data = $this->model::select()->where($this->column, '=', $this->input)->get();
        if (!empty($data)) {
            return false;
        }

        return true;
    }
}
