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
        if (getSession($key) === $value) {
            return true;
        }
        return false;
    }

    public function check()
    {
        if (getSession('id')) {
            return true;
        }
        return false;
    }
}
