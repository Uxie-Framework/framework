<?php

namespace Router;

interface UrlMatcherInterface
{
    public function match(): bool;
}
