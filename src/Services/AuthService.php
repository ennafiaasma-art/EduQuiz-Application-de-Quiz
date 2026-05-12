<?php
declare(strict_types=1);

namespace Src\Services;

use Src\Repositories\UserRepository;
use Src\Entities\Formateur;
use Src\Entities\Student;

require_once __DIR__ . "/../../config/DB.php";
require_once __DIR__ . "/../Repositories/UserRepository.php";
require_once __DIR__ . "/../Entities/User.php";
require_once __DIR__ . "/../Entities/Student.php";
require_once __DIR__ . "/../Entities/Formateur.php";

class AuthService
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function register(string $name, string $email, string $password, int $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($role === 1) {
            $user = new Formateur(
                $name,
                $email,
                $hashedPassword,
                $role
            );
        } else {
            $user = new Student(
                $name,
                $email,
                $hashedPassword,
                $role
            );
        }

        return $this->repo->create($user);
    }

    public function login(string $email, string $password): ?array
    {
        $user = $this->repo->findByEmail($email);

        if (!$user) {
            return null;
        }

        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }
}