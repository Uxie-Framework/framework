<?php

namespace Box;

class FileGenerator
{
    private $commandDirs = [
        'controller' => 'Controllers',
        'middleware' => 'Middlewares',
        'model'      => 'Models',
        'repository' => 'Repositories',
        'filter'     => 'Filters'
    ];
    private $command;
    private $argument;
    private $flag;
    private $template;
    private $fileInfo;

    public function __construct(string $command, string $argument, string $flag = null)
    {
        $this->command = $command;
        $this->argument = $argument;
        $this->flag = $flag;
        $this->fileInfo = $this->getFileLocationInfos(new FileLocationResolver(getAliase($this->commandDirs[strtolower($command)]), $argument));
        $this->template = $this->getTemplate();
    }

    public function create()
    {
        if (!file_put_contents($this->fileInfo->getFileDir().DIRECTORY_SEPARATOR.$this->fileInfo->getFileName().'.php', $this->template)) {
            echo "can't create file";
            exit();
        }

        echo "Success : $this->argument is created \n";
    }

    private function getTemplate()
    {
        $templateGenerator = 'Box\TemplateGenerators\\'.$this->command;
        return $this->generateTemplate(new $templateGenerator($this->fileInfo->getFileDir(), $this->fileInfo->getFileName(), $this->flag));
    }

    private function generateTemplate($templateGenerator)
    {
        return $templateGenerator->generate();
    }

    private function getFileLocationInfos(FileLocationResolver $resolver)
    {
        return $resolver;
    }
}
