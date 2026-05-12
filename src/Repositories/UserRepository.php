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
       $stateSql = $this->pdo->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?) ");
       return $stateSql->execute([
           $user->getName(),
           $user->getEmail(),
           $user->getPassword(),
           $user->getRoleId()
       ]);

   }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT users.*, roles.name AS role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.email = ?
    ");        $stmt->execute([$email]);

        $user = $stmt->fetch(\PDO::FETCH_OBJ);

        return $user ?: null;
    }
}