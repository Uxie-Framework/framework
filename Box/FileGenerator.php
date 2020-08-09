<?php

namespace Box;

class FileGenerator
{
    private $commandDirectories = [
        'controller' => 'Controllers',
        'middleware' => 'Middlewares',
        'model'      => 'Models',
        'repository' => 'Repositories',
        'filter'     => 'Filters'
    ];
    private $commandShortcuts = [
        'controller' => 'Controller',
        'middleware' => 'Middleware',
        'model'      => 'Model',
        'repository' => 'Repositorie',
        'filter'     => 'Filter'
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
        $this->fileInfo = $this->getFileLocationInfos(new FileLocationResolver(getAliase($this->commandDirectories[strtolower($command)]), $argument));
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
        $templateGenerator = 'Box\TemplateGenerators\\'.$this->commandShortcuts[strtolower($this->command)];
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
