<?php
require_once __DIR__ . '/../modal/User.php';


class UserRepositroy
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new connexion();
        $this->pdo = $db->getConnexion();
    }

    public function add(User $user)
    {
        $sql = "INSERT INTO users (name,email,contact)VALUE(?,?,?) ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user->getName(), $user->getEmail(), $user->getContact()]);
    }
    public function delete(int $id)
    {
        $sql = "DELETE FROM  users WHERE id = ? ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
    public function update(int $id, User $user)
    {
        $sql = "UPDATE users SET name = ?,
                       email = ?,
                       contact = ? 
        WHERE id = ? ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user->getName(),$user->getEmail(),$user->getContact()]);
    }
    public function selectAll(){
        $sql = "SELECT * FROM users ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}
