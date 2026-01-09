<?php
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Repository/RoleRepository.php';


class UserService
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->roleRepository = new RoleRepository();
    }

    public function findUser($email): ?User
    {
        $user = $this->userRepository->findByEmail($email);
        return $user;
    }

    public function login(string $email, string $pssword): ?User
    {

        if (!$this->userRepository->findByEmail($email)) {
            echo "<script>alert(\" votre email est incorrect !!\")</script>";

            header("Location: Authents/login.html");
        
        }
        $row = $this->userRepository->findByEmail($email);
        if (!password_verify($pssword, $row->getPassword())) {
            echo "<script>alert(\" votre password incorrect  !!\")</script>";

            header('Location: Authents/login.html');
            
        }
        return $row;
    }
    public function signeUp(string $name, string $email, string $password, Role $role): void
    {

        if ($this->userRepository->findByEmail($email)) {
            echo "<script>alert(\" email already exeste !!\")</script>";
            header("Location: Authents/signeUp.html");
            exit;
        }

        $rol = $this->roleRepository->selectRoleByNmae($role->getName());
        if (!$rol) {
            $this->roleRepository->add($role);
            $rol = $this->roleRepository->selectRoleByNmae($role->getName());
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new User($name, $email, $hashedPassword, $rol);

        $this->userRepository->add($user);
    }
}
