<?php

namespace src\key_checker;

class KeyChecker
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function check()
    {
        if($this->key == "")
        {
            return false;
        }

        if($this->key != "potato")
        {
            return false;
        }

        return true;
    }
}