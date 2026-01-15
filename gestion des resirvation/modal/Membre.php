<?php
// namespace App\modal;

class Membre extends User
{
    private int $id ;

    public function __construct(string $name, string $email, string $contact, ?DATETIME $date_creation = NULL, int $id)
    {
        return parent::__construct($name, $email, $contact, $date_creation);
        $this->id = $id;

    }

    public function getId()
    {
        return $this->id;
    }
}
