<?php

namespace Services;

class LanguagesResolver
{
    private static $paths = [];

    public static function resolve(string $path): array
    {
        if (in_array($path, static::$paths)) {
            return static::$paths[$path];
        }
        static::savePath($path);
        return static::$paths[$path];
    }

    private static function savePath(string $path): void
    {
        $fullDir = rootDir().'resources/languages/'.$path.'.php';
        
        if (!file_exists($fullDir)) {
            throw new \Exception("Language file you are looking for don't exist: $path", 89);
        }

        static::$paths[$path] = require $fullDir;
    }
}
