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

    

    public function update(int $id, string $question): bool {
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

     public function getQuestionsByQuiz(int $quizId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM questions WHERE quiz_id = ? ORDER BY id DESC"
        );

        $stmt->execute([$quizId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     public function countQuestionsByQuiz(int $quizId): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) AS total FROM questions WHERE quiz_id = ?"
        );

        $stmt->execute([$quizId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)($result['total'] ?? 0);
    }

    /**
     * Check whether a question exists.
     */
    public function questionExists(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT id FROM questions WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
        



    }
