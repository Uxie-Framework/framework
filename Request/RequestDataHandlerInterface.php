<?php

namespace Request;

interface RequestDataHandlerInterface
{
    public function handleBody(): Body;
    public function handleFiles(): Files;
}
