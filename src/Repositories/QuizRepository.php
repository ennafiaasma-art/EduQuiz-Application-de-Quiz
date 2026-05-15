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

    public function allByTeacher(int $teacherId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE teacher_id = ?"
        );

        $stmt->execute([$teacherId]);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE id = ?");
        $stmt->execute([$id]);

        $quiz = $stmt->fetch(PDO::FETCH_OBJ);

        return $quiz ?: null;
    }

    public function findByAccessCode(string $code)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE accesscode = ?");
        $stmt->execute([$code]);

        $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

        return $quiz ?: null;
    }

    public function update(int $id, string $title, string $description)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE quizzes SET title = ?, description = ? WHERE id = ?"
        );

        return $stmt->execute([$title, $description, $id]);
    }

    public function delete(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM quizzes WHERE id = ?");

        return $stmt->execute([$id]);
    }

}