<?php
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Repository/RoleRepository.php';
require_once __DIR__ . '/../database/Connexion.php';

class AuthService
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function signeUp(string $name, string $email, string $password, Role $role): void
    {

        if ($this->userRepository->findByEmail($email)) {

            throw new Exception(" !! Email deja utiliser ");
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

    public function login(string $email, string $pssword):?array
    {

        if (!$this->userRepository->findByEmail($email)) {
            header("Location: ../Authents/login.html");
            throw new Exception(" !! email incorrect !! ");
            exit;
        }
        $row = $this->userRepository->findByEmail($email);
        if (!password_verify($pssword, $row['password'])) {
            header("Location: ../Authents/login.html");
            throw new Exception(" !! password incorrect !! ");
            exit;
        }
        return $row;

    }
}
