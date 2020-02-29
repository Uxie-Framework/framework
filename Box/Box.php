<?php

namespace Box;

class Box
{
    public function __construct(string $command, string $argument, string $flag = null)
    {
        $this->executeCommand(new Generator($command, $argument, $flag));
    }

    private function executeCommand(Generator $command)
    {
        $command->execute();
    }
}
