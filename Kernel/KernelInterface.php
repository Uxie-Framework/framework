<?php

namespace Kernel;

interface KernelInterface
{
    public function prepare(): void;
    public function start(): void;
    public function stop(): void;
}
