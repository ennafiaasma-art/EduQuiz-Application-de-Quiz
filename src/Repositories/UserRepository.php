<?php

namespace Src\Repositories;
use Src\Entities\User;

require_once __DIR__ . "/../../config/DB.php";

class UserRepository
{
    private $pdo;

   public function __construct() {
       $this->pdo = \DB::connect();
   }

   public function create(User $user)
   {
       $stateSql = $this->pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?) ");
       return $stateSql->execute([
           $user->getName(),
           $user->getEmail(),
           $user->getPassword(),
           $user->getRole()
       ]);

   }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        return $user ?: null;
    }
}