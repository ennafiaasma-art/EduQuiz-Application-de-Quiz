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

    public function createQuiz(string $title, string $description, int $teacherId) {
        if (empty($title) || empty($description)) {
            return false;
        }

        try {
            $accessCode = $this->generateAccessCode();

            $quiz = new Quiz(
                $title,
                $description,
                $accessCode,
                $teacherId
            );

            if ($this->repo->create($quiz)) {
                return $accessCode;
            }
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function generateAccessCode()
    {
        return strtoupper(substr(md5(uniqid()), 0, 6));
    }

}