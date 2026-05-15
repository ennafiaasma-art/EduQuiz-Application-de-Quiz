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
     * Create answer (requested API)
     */
    public function createAnswer(
        int $questionId,
        string $answer,
        bool $isCorrect
    ): bool {
        if ($questionId <= 0 || empty(trim($answer))) {
            return false;
        }

        try {
            return $this->repo->create(
                $questionId,
                trim($answer),
                $isCorrect
            );
        } catch (\Throwable $e) {
            return false;
        }
    }


    public function create(
        int $questionId,
        string $answer,
        bool $isCorrect
    ): bool {
        return $this->createAnswer($questionId, $answer, $isCorrect);
    }


    public function getAnswersByQuestion(int $questionId): array
    {
        if ($questionId <= 0) {
            return [];
        }

        try {
            return $this->repo->getAnswersByQuestion($questionId);
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function deleteAnswersByQuestion(int $questionId): bool
    {
        if ($questionId <= 0) {
            return false;
        }

        try {
            return $this->repo->deleteByQuestion($questionId);
        } catch (\Throwable $e) {
            return false;
        }
    }


    public function deleteByQuestion(int $questionId): bool
    {
        return $this->deleteAnswersByQuestion($questionId);
    }
}