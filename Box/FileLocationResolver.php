<?php

namespace Box;

class FileLocationResolver
{
    private array $fileInfo;
    private string $fullDir;

    public function __construct(string $mainDir, string $fullName)
    {
        $this->fileInfo = pathinfo($fullName);
        $this->fullDir  = $this->resolveDir($mainDir, $this->fileInfo['dirname']);
    }

    private function resolveDir(string $mainDir, string $dir): string
    {
        if ($dir === '.') {
            return $mainDir;
        }

        return $mainDir . '/' . $this->fileInfo['dirname'];
    }

    public function getFileName(): string
    {
        return $this->fileInfo['filename'];
    }

    public function getFileDir(): string
    {
        if (!is_dir($this->fullDir)) {
            $this->createDir();
        }

        if (!is_writable($this->fullDir)) {
            throw new \Exception("Directory '{$this->fullDir}' is not writable");
        }

        return $this->fullDir;
    }

    private function createDir(): void
    {
        if (!mkdir($this->fullDir, recursive: true) && !is_dir($this->fullDir)) {
            throw new \Exception("Can't create directory: {$this->fullDir}");
        }
    }
}
