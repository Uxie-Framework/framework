<?php

namespace Services;

class ErrorHandler
{
    public function handle(\Throwable $e)
    {
        container()->Logger->error($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
        $code = $e->getCode();
        $error = $e->getMessage();
        if (getenv('PRODUCTION_MODE') === 'ON') {
            $code = 'ERROR';
            $error = '404';
        }

        view('CoreViews/error', ['code' => $code, 'error' => $error]);
    }
}
