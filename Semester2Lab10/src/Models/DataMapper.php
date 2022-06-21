<?php

namespace Models;

use PDO;

class DataMapper
{
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=localhost;dbname=app10", "app10user", "*****");
    }

    public function getUser($login): ?array
    {
        $query = $this->connection->prepare("select * from app10.usersTable where login like '$login'");
        $query->execute();

        $result = $query->fetch();

        if (!$result)
        {
            return null;
        }

        return $result;
    }

    public function deleteUser($login)
    {
        $query = $this->connection->prepare("delete from app10.usersTable where login like '$login'");
        $query->execute();
    }

    public function registerUser($login, $password): bool
    {
        $hash = md5($password);
        $query = $this->connection->prepare("insert into app10.usersTable (login, hash) values ('$login','$hash')");
        return $query->execute();
    }
}
