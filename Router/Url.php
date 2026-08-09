<?php

namespace Router;

class Url implements UrlInterface
{
    private string $url;

    public function __construct()
    {
        $this->url = urldecode((string) ltrim($_SERVER['REQUEST_URI'] ?? '', '/'));
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
