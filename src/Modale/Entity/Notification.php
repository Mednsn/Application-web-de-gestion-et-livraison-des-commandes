<?php
require_once __DIR__ . '/Modale/User.php';
;
class Notification {
    private ?int $id ;
    private string $message ;
    private ?DATETIME $date_creation ;
    private User $client;
    private bool $is_read ;

public function __construct(string $message, ?DATETIME $date_creation=NULL, User $client, bool $is_read,?int $id=NULL)
{
    $this->message = $message;
    $this->date_creation = $date_creation;
    $this->client = $client;
    $this->is_read = $is_read;
    $this->id = $id;
    
} 

public function getId(){
     return $this->id;
}
public function setId($id){
     return $this->id=$id;
}
public function getMessage(){
     return $this->message;
}
public function getDateCreation(){
     return $this->date_creation;
}
public function getClient(){
     return $this->client;
}
public function getIsRead(){
     return $this->is_read;
}
public function setMessage($message){
     return $this->message=$message;
}
public function setDateCreation($date_creation){
     return $this->date_creation=$date_creation;
}
public function setClient($client){
     return $this->client=$client;
}
public function setIsRead($is_read){
     return $this->is_read=$is_read;
}


}