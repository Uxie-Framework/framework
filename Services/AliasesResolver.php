<?php

namespace Services;

class AliasesResolver
{
    use \Services\Traits\Aliases;

    public static function resolve(string $shortname)
    {
        return static::$aliases[$shortname];
    }
}
