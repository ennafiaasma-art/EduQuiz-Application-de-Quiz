<?php

declare(strict_types=1);
namespace Src\Repositories;
require_once __DIR__ . "/../../config/DB.php";

use PDO;

class QuestionRepository
{
    private $pdo;

    public function __construct() {
        $this->pdo = \DB::connect();
    }  


     public function create(int $quizId, string $question): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO questions(quiz_id, question)
             VALUES (?, ?)"
        );

        $stmt->execute([$quizId, $question]);

        return (int)$this->pdo->lastInsertId();
    }

    

    public function update(int $id, string $question): bool{

    }

    }
