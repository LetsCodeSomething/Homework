<?php

namespace DataMapper;

use Component\Component;

class DataMapper
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = new \PDO("mysql:host=localhost;dbname=app8", "app8user", "*****");
    }

    public function getAllComponents() : ?array
    {
        $query = $this->connection->prepare("select * from app8.component");
        $query->execute();
        return $query->fetchAll();
    }

    public function saveComponent($component)
    {
        $id = $component->getId();
        $name = $component->getName();
        $description = $component->getDescription();
        $material = $component->getMaterial();

        $query = $this->connection->prepare(
            "insert into app8.component (id, name, description, material)
             values ($id, '$name', '$description', '$material')");
        $query->execute();
    }

    public function deleteComponent($component)
    {
        $id = $component->getId();

        $query = $this->connection->prepare("delete from app8.component where id = $id");
        $query->execute();
    }
}
