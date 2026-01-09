<?php
require_once __DIR__ . '/../database/Connexion.php';
require_once __DIR__ . '/../Entity/Role.php';


class RoleRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Connexion();
        $this->pdo = $db->getConnexion();
    }

    public function add(Role $role): void
    {
        $sql = "INSERT INTO roles (name)
             VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['name' => $role->getName()]);
    }
    public function selectRoleByNmae(string $name): ?Role
    {
        $sql = "SELECT * FROM roles WHERE name= ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row){
            return NULL;
        }else{
            return new Role($row['name'],$row['id']);
        }
    }
}
