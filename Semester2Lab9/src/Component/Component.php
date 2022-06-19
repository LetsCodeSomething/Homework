<?php

namespace Component;

class Component
{

    private int $id;
    private string $name;
    private string $description;
    private string $material;

    public function __construct($id, $name, $description, $material)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->material = $material;
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
}
