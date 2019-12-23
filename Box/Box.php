<?php

namespace Box;

class Box
{
    public function __construct(string $command, string $argument, string $flag = null)
    {
        $this->executeCommand(new Generator(strtolower($command), strtolower($argument), strtolower($flag)));
    }

    private function executeCommand(Generator $command)
    {
        $command->execute();
    }
}
