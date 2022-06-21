<?php

namespace Controllers;

use Models\DataMapper;

class UserController
{
    private $dataMapper;

    public function __construct()
    {
        $this->dataMapper = new DataMapper();
    }

    public function verifyUserByToken($login, $token): bool
    {
        $arr = $this->dataMapper->getUser($login);

        //Пользователь не существует
        if(!$arr)
        {
            return false;
        }

        if(md5($arr["hash"]) == $token)
        {
            return true;
        }

        return false;
    }

    public function verifyUserByPassword($login, $password): bool
    {
        $arr = $this->dataMapper->getUser($login);

        //Пользователь не существует
        if(!$arr)
        {
            return false;
        }

        if($arr["hash"] == md5($password))
        {
            return true;
        }

        return false;
    }

    public function deleteUser($login)
    {
        $this->dataMapper->deleteUser($login);
    }

    public function registerUser($login, $password): bool
    {
        return $this->dataMapper->registerUser($login, $password);
    }
}
