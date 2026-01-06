<?php
require_once __DIR__ . '/Role.php';
class User {

    private ?int $id ;
    private string $name ;
    private string  $email ;
    private string $password ;
    private ?DATETIME $date_creation ;
    private Role $role;

public function __construct(string $name ,string  $email ,string $password,Role $role, ?DATETIME $date_creation=NULL , ?int $id=NULL)
{
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->date_creation = $date_creation;
    $this->role = $role;
    $this->id = $id;
    
} 
public function getId(){
     return $this->id;
}
public function setId($id){
     return $this->id=$id;
}
public function getName(){
     return $this->name;
}
public function getEmail(){
     return $this->email;
}
public function getPassword(){
     return $this->password;
}
public function getDateCreation(){
     return $this->date_creation;
}
public function getRole(){
     return $this->role;
}
}