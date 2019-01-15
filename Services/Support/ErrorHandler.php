<?php

namespace Services\Support;

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

        container()->Response->view('CoreViews/error', ['code' => $code, 'error' => $error])->send();
    }
}
