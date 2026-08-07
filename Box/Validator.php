<?php

namespace Box;

class Validator
{
    private $commands = ['controller', 'model', 'middleware', 'repository', 'filter'];

    public function validate($command)
    {
        if (!in_array(strtolower($command), $this->commands)) {
            exit("this command $command does not exist \n");
        }
    }
}
