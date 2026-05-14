<?php
declare(strict_types=1);

namespace Src\Services;

use Src\Repositories\QuizRepository;
use Src\Entities\Quiz;

require_once __DIR__ . "/../../config/DB.php";
require_once __DIR__ . "/../Repositories/QuizRepository.php";
require_once __DIR__ . "/../Entities/Quiz.php";

class QuizService
{
    private QuizRepository $repo;

    public function __construct()
    {
        $this->repo = new QuizRepository();
    }

    public function createQuiz(
        string $title,
        string $description,
        int $teacherId
    ) {

        if (empty($title) || empty($description)) {
            throw new \Exception("All fields are required");
        }

        $accessCode = $this->generateAccessCode();

        $quiz = new Quiz(
            $title,
            $description,
            $accessCode,
            $teacherId
        );

        return $this->repo->create($quiz);
    }

    public function generateAccessCode(): string
    {
        return strtoupper(substr(md5(uniqid()), 0, 6));
    }

    public function getTeacherQuizzes(int $teacherId): array
    {
        return $this->repo->allByTeacher($teacherId);
    }

    public function updateQuiz(
        int $id,
        string $title,
        string $description
    ) {

        if (empty($title) || empty($description)) {
            throw new \Exception("All fields are required");
        }

        return $this->repo->update(
            $id,
            $title,
            $description
        );
    }

    public function deleteQuiz(int $id)
    {
        return $this->repo->delete($id);
    }

    public function findByAccessCode(string $code): ?array
    {
        return $this->repo->findByAccessCode($code);
    }
}