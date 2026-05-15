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

    /**
     * Create question (requested API)
     */
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

    /**
     * Update question (requested API)
     */
    public function updateQuestion(int $id, string $text): bool
    {
        if ($id <= 0 || empty(trim($text))) {
            return false;
        }

        try {
            if (!$this->repo->questionExists($id)) {
                return false;
            }

            return $this->repo->update($id, trim($text));
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Backward-compatible alias
     */
    public function update(int $id, string $question): bool
    {
        return $this->updateQuestion($id, $question);
    }

    /**
     * Delete question (requested API)
     */
    public function deleteQuestion(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        try {
            if (!$this->repo->questionExists($id)) {
                return false;
            }

            return $this->repo->delete($id);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Backward-compatible alias
     */
    public function delete(int $id): bool
    {
        return $this->deleteQuestion($id);
    }

    /**
     * Get one question
     */
    public function findById(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        try {
            return $this->repo->findById($id);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Get all questions by quiz
     */
    public function getQuestionsByQuiz(int $quizId): array
    {
        if ($quizId <= 0) {
            return [];
        }

        try {
            return $this->repo->getQuestionsByQuiz($quizId);
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Count quiz questions
     */
    public function countQuestionsByQuiz(int $quizId): int
    {
        if ($quizId <= 0) {
            return 0;
        }

        try {
            return $this->repo->countQuestionsByQuiz($quizId);
        } catch (\Throwable $e) {
            return 0;
        }
    }
}