<?php

namespace Authenticator;

class Check
{
    private $id;
    private $optionalValue;

    public function checkif(array $conditions)
    {
        foreach ($conditions as $key => $value) {
            $checked = $this->checkCondition($key, $value);
            if (!$checked) {
                return false;
            }
        }
        return true;
    }

    private function checkCondition(string $key, string $value)
    {
        if (session($key) === $value) {
            return true;
        }
        return false;
    }

    public function check()
    {
        if (session('id')) {
            return true;
        }
        return false;
    }
}
