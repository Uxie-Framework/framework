<?php

namespace Box;

class Generator
{
    public function __construct(string $command, string $argument, string $flag = null)
    {
        $this->command = $command;
        $this->argument = $argument;
        $this->flag = $flag;
    }

    public function execute()
    {
        $this->validate(new Validator($this->command));
        $this->create(new FileGenerator($this->command, $this->argument, $this->flag));
    }

    private function validate(Validator $validator)
    {
        $validator->validate($this->command);
    }

    private function create(FileGenerator $generator)
    {
        $generator->create();
    }
}
