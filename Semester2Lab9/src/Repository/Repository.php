<?php

namespace Repository;

use DataMapper\DataMapper;
use Component\Component;

class Repository
{
    private DataMapper $dataMapper;
    private $components = [];

    public function __construct()
    {
        $this->dataMapper = new DataMapper();
        $this->components = $this->dataMapper->getAllComponents();
    }

    public function getAllComponents(): ?array
    {
        return $this->components;
    }

    public function getComponentById($id): ?array
    {
        $componentsArr = [];

        foreach ($this->components as $component)
        {
            if ($component->getId() == $id)
            {
                $componentsArr[] = $component;
                return $componentsArr;
            }
        }

        return null;
    }

    public function getAllComponentsByValue($column, $value): ?array
    {
        $componentsArr = [];

        if($column == "name")
        {
            foreach($this->components as $component)
            {
                if ($component->getName() == $value)
                {
                    $componentsArr[] = $component;
                }
            }
        }
        else if($column == "description")
        {
            foreach($this->components as $component)
            {
                if ($component->getDescription() == $value)
                {
                    $componentsArr[] = $component;
                }
            }
        }
        else if($column == "material")
        {
            foreach($this->components as $component)
            {
                if ($component->getMaterial() == $value)
                {
                    $componentsArr[] = $component;
                }
            }
        }

        return $componentsArr;
    }

    public function saveComponent($component)
    {
        $this->dataMapper->saveComponent($component);
        $this->components = $this->dataMapper->getAllComponents();
    }

    public function deleteComponent($component)
    {
        $this->dataMapper->deleteComponent($component);
        $this->components = $this->dataMapper->getAllComponents();
    }
}
