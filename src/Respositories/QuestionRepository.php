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

    

    public function modifier(int $id, string $question): bool {
         $stmt = $this->pdo->prepare(
            "UPDATE questions SET question = ? WHERE id = ?"
        );

        return $stmt->execute([$question, $id]);
        

    }


        public function effacer(int $id): bool
        {
            $stmt = $this->pdo->prepare(
            "DELETE FROM questions WHERE id = ?"
        );

        return $stmt->execute([$id]);
        }
    
           public function TrouverQuestionById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM questions WHERE id = ?"
        );

        $stmt->execute([$id]);

        $question = $stmt->fetch(PDO::FETCH_ASSOC);

        return $question ?: null;
    }
        



    }
