<?php


class Vehicule
{
    private ?int $id;
    private string $name;
    public function __construct(string $name, ?int $id = NULL)
    {
        $this->name = $name;
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setName($name)
    {
        return $this->name = $name;
    }
}
