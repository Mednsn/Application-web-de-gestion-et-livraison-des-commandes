<?php
require_once __DIR__ . '/../Entity/User.php';
require_once __DIR__ . '/../Entity/Role.php';
require_once __DIR__ . '/../database/Connexion.php';

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Connexion();
        $this->pdo = $db->getConnexion();
    }

    public function findByEmail(string $email): ?User
    {
        $sql="SELECT r.id AS R_id,r.name AS role,u.* FROM users u INNER JOIN roles r ON r.id=u.role_id WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }
        $role=new Role($data['role'],$data['R_id']);
        $date_creation= new DateTime($data['date_creation']);

        return new User($data['name'],$data['email'],$data['password'],$role,$date_creation,$data['id']);
    }
     public function findByEmailJUSTEFORTEST(string $email): ?array
    {
        $sql="SELECT r.id AS R_id,r.name AS role,u.* FROM users u INNER JOIN roles r ON r.id=u.role_id WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }
        

        return $data;
    }

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
