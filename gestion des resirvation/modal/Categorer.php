<?php
// namespace App\modal;

class Categorer
{
    private ?int $id;

    private string $name;

    public function __construct(string $name, int $id = null)
    {
        $this->name = $name;
    }

    public function getId(){
        return $this->id;
    }
    public function getNmae(){
        return $this->name;
    }
  
   
}
