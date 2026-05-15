<?php

declare(strict_types=1);

namespace Src\Services;

use Src\Repositories\QuestionRepository;

require_once __DIR__ . "/../Repositories/QuestionRepository.php";

class QuestionService
{
    private QuestionRepository $repo;

    public function __construct()
    {
        $this->repo = new QuestionRepository();
    }


     public function createQuestion(int $quizId, string $text): int
    {
        if ($quizId <= 0 || empty(trim($text))) {
            return 0;
        }

        try {
            return $this->repo->create($quizId, trim($text));
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Backward-compatible alias
     */
    public function create(int $quizId, string $question): int
    {
        return $this->createQuestion($quizId, $question);
    }

 }