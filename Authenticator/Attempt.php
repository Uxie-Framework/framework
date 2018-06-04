<?php

namespace Authenticator;

class Attempt
{
    private $data;
    private $table;
    private $identifier;
    private $password;
    private $optionalValue;
    private $userData;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->secure();
        $this->setup();
    }

    public function login()
    {
        if ($this->checkUserValide()) {
            $this->startSession();
            return true;
        }
        return false;
    }

    private function checkUserValide()
    {
        $this->userData = $this->getUserData();
        if (!empty($this->userData)) {
            return $this->confirmPassword($this->userData[0]) ? true : false;
        }
        return false;
    }

    private function getUserData()
    {
        $model = "\Model\\".$this->table['value'];
        if ($this->optionalValue['value']) {
            return $model::select()->where($this->identifier['key'], '=', $this->identifier['value'])->where($this->optionalValue['key'], '=', $this->optionalValue['value'])->get();
        }
        return $model::find($this->identifier['key'], $this->identifier['value']);
    }

    private function confirmPassword($userData)
    {
        return password_verify($this->password['value'], $userData->{$this->password['key']});
    }

    private function startSession()
    {
        foreach ((array)$this->userData[0] as $key => $value) {
            if ($this->password['key'] !== $key) {
                session($key, $value);
            }
        }
        session('time', time());
    }

    private function setup()
    {
        $keys = array_keys($this->data);
        $values = array_values($this->data);

        $this->table['value'] = $values[0];

        $this->identifier['key']   = $keys[1];
        $this->identifier['value'] = $values[1];

        $this->password['key']   = $keys[2];
        $this->password['value'] = $values[2];

        $this->optionalValue['key']   = isset($keys[3]) ? $keys[3] : null;
        $this->optionalValue['value'] = isset($values[3]) ? $values[3] : null;
    }

    /**
     * remove white spaces from inputs & add slashes
     *
     * @return void
    */
    private function secure()
    {
        foreach ($this->data as $key => $value) {
            $secured[$key] = trim(addslashes($value));
        }
        $this->data = $secured;
    }
}
