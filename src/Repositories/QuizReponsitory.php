<?php
namespace App\Repositoies;
use App\Entities\Question;
use App\Entities\Answer;
use PDO;

class QuizRepository{
    private PDO $db;

    public function __construct($db){
        $this->db = $db;
    }
    public function findByCode(string $code){
        $stmt = $this->db->prepare("SELECT * FROM quizzes WHERE accesscode = :code");
        $stmt->executr(['code'=>$code]);
        return $stmt->fetch(PDO::FETCH_OBG);
    }
    public function getFullQuizData(int $quizId):arry{
        $sql = "SELECT q.id as q_id, q.question, a.id as a_id, a.answer_text
        FROM questions q
        LEFT JOIN answers a ON q.id = a.question_id
        WHERE q.quiz_id = :quiz_id";
    }
}