<?php

declare(strict_types=1);

namespace Src\Services;

use Src\Repositories\AnswerRepository;

require_once __DIR__ . "/../Repositories/AnswerRepository.php";

class AnswerService
{
    private AnswerRepository $repo;

    public function __construct()
    {
        $this->repo = new AnswerRepository();
    }

    /**
     * Create answer
     */
    public function create(
        int $questionId,
        string $answer,
        bool $isCorrect
    ): bool
    {
        if (empty(trim($answer))) {
            throw new \Exception("Answer is required");
        }

        return $this->repo->create(
            $questionId,
            $answer,
            $isCorrect
        );
    }

    /**
     * Get answers by question
     */
    public function getAnswersByQuestion(int $questionId): array
    {
        return $this->repo->getAnswersByQuestion($questionId);
    }

    /**
     * Delete all answers of question
     */
    public function deleteByQuestion(int $questionId): bool
    {
        return $this->repo->deleteByQuestion($questionId);
    }
}