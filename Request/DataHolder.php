<?php

namespace Request;

interface DataHolder
{
    public function __set(string $key, ?string $value): void;
    public function __get(string $key): ?string;
    public function __isset(string $key): bool;
}
