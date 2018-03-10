<?php

namespace Router;

interface RouteResolverInterface
{
    public function validate(): bool;
    public function getUrlVariables(): array;
}
