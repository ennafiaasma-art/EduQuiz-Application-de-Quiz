<?php
declare(strict_types=1);
namespace Src\Services;
use Src\Repositories\UserRepository;

require_once __DIR__ . "/../../config/DB.php";
require_once __DIR__ . "/../Repositories/UserRepository.php";

class AuthService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function register(string $name, string $email, string $password, string $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = new User(
            null,
            $name,
            $email,
            $hashedPassword,
            $role
        );

        return $this->repo->create($user);

    }

}