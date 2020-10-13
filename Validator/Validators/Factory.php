<?php
namespace Validator\Validators;

use Validator\Validators\Validatable as Validatable;

class Factory
{
    private $validators = [
        'email'    => 'Email',
        'equals'   => 'Equals',
        'isfloat'  => 'IsFloat',
        'isint'    => 'IsInt',
        'isip'     => 'IsIp',
        'isdate'   => 'IsDate',
        'length'   => 'Length',
        'required' => 'Required',
        'unique'   => 'Unique',
        'url'      => 'Url',
    ];
    public static function create(string $validator, ...$arguments): Validatable
    {
        return (new Self())->return($validator, ...$arguments);
    }

    public function return(string $validator, ...$arguments): Validatable
    {
        $validator = "Validator\Validators\\".$this->resolveValidator($validator);
        return new $validator(...$arguments);
    }

    private function resolveValidator(string $validator): string
    {
        return $this->validators[strtolower($validator)];
    }
}
