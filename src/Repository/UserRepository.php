<?php
require_once __DIR__ . '/../Modale/Entity/User.php';
require_once __DIR__ . '/../Modale/Entity/Role.php';
require_once __DIR__ . '/../database/Connexion.php';
require_once __DIR__ . '/../Modale/viewModale/UserJoinRole.php';

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Connexion();
        $this->pdo = $db->getConnexion();
    }

    public function findByEmail(string $email)
    {
        $sql="SELECT r.id AS R_id,r.name AS role,u.* FROM users u INNER JOIN roles r ON r.id=u.role_id WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,UserJoinRole::class);
        $data = $stmt->fetch();
        return $data;
    }
    public function findByEmailById(int $id)
    {
        $sql="SELECT r.id AS R_id,r.name AS role,u.* FROM users u INNER JOIN roles r ON r.id=u.role_id WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS,UserJoinRole::class);
        $data = $stmt->fetch();
        return $data;
    }
    // public function findUserByEmail(string $email)
    // {
    //     $sql="SELECT * FROM users  WHERE email = :email LIMIT 1";
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->execute(['email' => $email]);
    //     $stmt->setFetchMode(PDO::FETCH_CLASS,User::class);
    //     $data = $stmt->fetch();
    //     return $data;
    // }

    public function add(User $user): void
    {
        $sql="INSERT INTO users (name,email, password, role_id ) VALUES (:name, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole()->getId()
        ]);
    }
}
