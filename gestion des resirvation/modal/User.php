<?php
namespace App\modal;

class User
{
    private ?int $id;

    private string $name;

    private string $email;

    private string $contact;

    public function __construct(string $name, string $email, string $contact, int $id = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->contact = $contact;
    }

    public function getId(){
        return $this->id;
    }
    public function getNmae(){
        return $this->name;
    }
    public function getContact(){
        return $this->contact;
    }
    public function getEmail(){
        return $this->email;
    }
}
