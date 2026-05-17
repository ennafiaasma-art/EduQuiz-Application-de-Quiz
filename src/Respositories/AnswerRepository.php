<?php
declare(strict_types=1);

namespace Src\Repositories;

require_once __DIR__ . "/../../config/DB.php";

use PDO;

class AnswerRepository{

    private $pdo;

    public function __construct()
    {
        $this->pdo = \DB::connect();
    }
 public function create(int $questionId, string $answer, bool   $isCorrect )
    {

        $stmt = $this->pdo->prepare(
            "INSERT INTO answers(question_id, answer_text, is_correct)
             VALUES (?, ?, ?)"
        );

        return $stmt->execute([
            $questionId,
            $answer,
            $isCorrect
        ]);
    }

         // Récupérer les réponses d'une question

    public function getAnswersByQuestion(int $questionId): array {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM answers WHERE question_id = ? ORDER BY id ASC"
        );

        $stmt->execute([$questionId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer toutes les réponses d'une question
      public function deleteByQuestion(int $questionId): bool
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM answers WHERE question_id = ?"
        );

        return $stmt->execute([$questionId]);
    }



}

?>