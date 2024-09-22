<?php

namespace Box\TemplateGenerators;

abstract class TemplateGenerator
{
    private $directory;
    private $flag;
    private $fileName;

    public function __construct(string $directory, string $fileName, string $flag = null)
    {
        $this->directory = $directory;
        $this->fileName  = $fileName;
        $this->flag      = $flag;
        $this->adapter();
    }

    public function generate()
    {
        // The error of undefined template() is not correct because template() function comes from the Box\Templates files.
        return $this->template($this->directory, $this->fileName, $this->flag);
    }

    private function adapter()
    {
        $dir = explode('/', $this->directory);
        $dir = array_slice($dir, 2, count($dir));
        $this->directory = empty($dir) ? implode('\\', $dir) : '\\' . implode('\\', $dir);
    }
}
