<?php

namespace Authenticator;

class Check
{
    public function checkif(array $conditions): bool
    {
        foreach ($conditions as $key => $value) {
            $checked = $this->checkCondition($key, $value);
            if (!$checked) {
                return false;
            }
        }
        return true;
    }

    private function checkCondition(string $key, string $value): bool
    {
        if (getSession($key) === $value) {
            return true;
        }
        return false;
    }

    public function check(): bool
    {
        if (getSession('id')) {
            return true;
        }
        return false;
    }
}
