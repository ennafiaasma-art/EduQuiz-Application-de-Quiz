<?php
namespace App\Repositories; 
use PDO;

class QuizRepository {
    private ?PDO $db;

    public function __construct(?PDO $db) {
        $this->db = $db;
    }

    public function findByCode(string $code) {
        $stmt = $this->db->prepare("SELECT * FROM quizzes WHERE accesscode = :code");
        $stmt->execute(['code' => $code]); 
        return $stmt->fetch(PDO::FETCH_OBJ); 
    }

    public function getFullQuizData(int $quizId): array { 
        $sql = "SELECT q.id as q_id, q.question, a.id as a_id, a.answer_text
                FROM questions q
                LEFT JOIN answers a ON q.id = a.question_id
                WHERE q.quiz_id = :quiz_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['quiz_id' => $quizId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    }
}