<?php

namespace Router;

interface UrlMatcherInterface
{
    public function matchURL(): bool;
}
