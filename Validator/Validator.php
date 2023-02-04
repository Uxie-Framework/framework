<?php

namespace Validator;

use Validator\Pipeline as Pipeline;
use Validator\Validators\Factory as Factory;

class Validator
{
    private $errors = [];
    private $pipeline;
    private $input;

    public static function start(): self
    {
        return new self();
    }

    public function __construct()
    {
        $this->pipeline = new Pipeline();
    }

    public function setInput(?string $input): self
    {
        $this->input = is_null($input) ? '' : $input;
        return $this;
    }

    public function validate(): self
    {
        $this->errors = $this->pipeline->process();
        $this->normalizeErrors(); // remove empty errors from the array
        return $this;
    }

    public function isValide(): bool
    {
        return empty($this->errors) ? true : false;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function normalizeErrors(): void
    {
        $this->errors = array_filter($this->errors, function (?string $value) {
            if (!is_null($value)) {
                return $value;
            }
        });
    }

    public function __call($validator, $arguments): self
    {
        if (isset($this->input)) {
            array_unshift($arguments, $this->input);
        }
        $this->pipeline->pipe(Factory::create($validator, ...$arguments));

        return $this;
    }
}
