<?php

namespace Box;

class FileLocationResolver
{
    private $fileInfo;
    private $fullDir;

    public function __construct(string $mainDir, string $fullName)
    {
        $this->fileInfo = pathinfo($fullName);
        $this->fullDir  = $this->resolveDir($mainDir, $this->fileInfo['dirname']);
    }

    private function resolveDir(string $mainDir, string $dir)
    {
        if ($dir === '.') {
            return $mainDir;
        }

        return $mainDir.'/'.$this->fileInfo['dirname'];
    }

    public function getFileName()
    {
        return $this->fileInfo['filename'];
    }

    public function getFileDir()
    {
        if (!is_dir($this->fullDir)) {
            $this->createDir();
        }

        if (!is_writable($this->fullDir)) {
            echo "$this->fullDir is not writable \n";
            exit();
        }

        return $this->fullDir;
    }

    private function createDir()
    {
        if (!mkdir($this->fullDir)) {
            echo "can't create Directory : $this->fullDir \n";
            exit();
        }
    }
}
