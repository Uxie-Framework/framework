<?php

namespace Box;

class Generator
{
    private string $command;
    private string $argument;
    private ?string $flag;

    public function __construct(string $command, string $argument, ?string $flag = null)
    {
        $this->command  = $command;
        $this->argument = $argument;
        $this->flag     = $flag;
    }

    public function execute(): void
    {
        $this->validate(new Validator());
        $this->create(new FileGenerator($this->command, $this->argument, $this->flag));
    }

    private function validate(Validator $validator): void
    {
        $validator->validate($this->command);
    }

    private function create(FileGenerator $generator): void
    {
        $generator->create();
    }
}
