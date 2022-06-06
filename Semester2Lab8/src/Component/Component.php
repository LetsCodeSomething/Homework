<?php

namespace Component;

class Component
{
    private \PDO $connection;
    private int $id;
    private string $name;
    private string $description;
    private string $material;

    public function __construct()
    {
        $this->connection = new \PDO("mysql:host=localhost;dbname=app8", "app8user", "*****");
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getMaterial() : string
    {
        return $this->material;
    }

    public function setMaterial($material)
    {
        $this->material = $material;
    }

    public function getAll() : ?array
    {
        $query = $this->connection->prepare("select * from app8.component");
        $query->execute();
        return $query->fetchAll();
    }

    public function getById($id) : ?Component
    {
        $query = $this->connection->prepare("select * from app8.component where id = $id");
        $query->execute();
        $result = $query->fetch();

        if($result)
        {
            $c = new Component();
            $c->setId($result["id"]);
            $c->setName($result["name"]);
            $c->setDescription($result["description"]);
            $c->setMaterial($result["material"]);

            return $c;
        }

        return null;
    }

    public function getAllByColumnValue($column, $value) : ?array
    {
        if(is_string($value))
        {
            $query = $this->connection->prepare("select * from app8.component where $column = '$value'");
        }
        else
        {
            $query = $this->connection->prepare("select * from app8.component where $column = $value");
        }

        $query->execute();

        return $query->fetchAll();
    }

    public function save()
    {
        $query = $this->connection->prepare(
            "insert into app8.component (id, name, description, material)
             values ($this->id, '$this->name', '$this->description', '$this->material')");
        $query->execute();
    }

    public function delete()
    {
        $query = $this->connection->prepare("delete from app8.component where id = $this->id");
        $query->execute();
    }
}
