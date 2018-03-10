<?php

namespace Router;

class Url implements UrlInterface
{
    private $url;

    public function __construct()
    {
        $this->url = urldecode(ltrim($_SERVER['REQUEST_URI'], '/'));
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
