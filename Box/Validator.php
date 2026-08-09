<?php

namespace Box;

class Validator
{
    private $commands = ['controller', 'model', 'middleware', 'repository', 'filter'];

    public function validate(string $command): void
    {
        if (!in_array($command, $this->commands)) {
            throw new \Exception("Command '$command' does not exist");
        }
    }
}
