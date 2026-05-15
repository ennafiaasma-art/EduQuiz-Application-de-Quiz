<?php
declare(strict_types=1);
namespace Src\Repositories;
require_once __DIR__ . "/../../config/DB.php";
require_once __DIR__ . "/../Entities/Quiz.php";

use Src\Entities\Quiz;
use PDO;

class QuizRepository
{
    private $pdo;

    public function __construct() {
        $this->pdo = \DB::connect();
    }

    public function create(Quiz $quiz)
    {
        $stmt = $this->pdo->prepare("INSERT INTO quizzes(title, description, accesscode, teacher_id) 
                                   VALUES (?, ?, ?, ?)");

        return $stmt->execute([
            $quiz->getTitle(),
            $quiz->getDescription(),
            $quiz->getAccessCode(),
            $quiz->getTeacherId()
        ]);
    }

    public function allByTeacher(int $teacherId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE teacher_id = ?"
        );

        $stmt->execute([$teacherId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}