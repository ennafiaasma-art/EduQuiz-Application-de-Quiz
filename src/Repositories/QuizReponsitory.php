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
}