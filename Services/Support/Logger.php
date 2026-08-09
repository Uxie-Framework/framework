<?php
namespace Services\Support;

use Request\Handler\Request as Request;
use Response\Response as Response;

class Logger
{
    private string $logDir;

    public function __construct()
    {
        $this->logDir = rootDir().'log';
    }

    public function error(string $error, mixed $code, int $line, string $file): void
    {
        $date = date('Y-m-d H:i:s');
        $message = "\n# code: {$code} # {$date} # {$error} # line {$line} # {$file}";
        file_put_contents($this->logDir.'/All_errors.log', $message, FILE_APPEND);
    }

    public function log(string $log, string $file): void
    {
        $date = date('Y-m-d H:i:s');
        file_put_contents("{$this->logDir}/{$file}.log", "\n{$date} # {$log}", FILE_APPEND);
    }
}
