<?php
require_once __DIR__ . '/../Entity/User.php';
require_once __DIR__ . '/../Repository/RoleRepository.php';
require_once __DIR__ . '/../database/Connexion.php';
class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?array
    {
            echo "<br> est entrer function de findbyemail\n";

        $stmt = $this->pdo->prepare("SELECT r.name AS role,u.* FROM users u INNER JOIN roles r ON r.id=u.role_id WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

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
