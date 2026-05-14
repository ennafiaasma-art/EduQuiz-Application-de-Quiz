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
     * Create question
     */
    public function create(int $quizId, string $question): int
    {
        if (empty($question)) {
            throw new \Exception("Question is required");
        }

        return $this->repo->create($quizId, $question);
    }

    /**
     * Update question
     */
    public function update(int $id, string $question): bool
    {
        if (!$this->repo->questionExists($id)) {
            throw new \Exception("Question not found");
        }

        if (empty($question)) {
            throw new \Exception("Question is required");
        }

        return $this->repo->update($id, $question);
    }

    /**
     * Delete question
     */
    public function delete(int $id): bool
    {
        if (!$this->repo->questionExists($id)) {
            throw new \Exception("Question not found");
        }

        return $this->repo->delete($id);
    }

    /**
     * Get one question
     */
    public function findById(int $id): ?array
    {
        return $this->repo->findById($id);
    }

    /**
     * Get all questions by quiz
     */
    public function getQuestionsByQuiz(int $quizId): array
    {
        return $this->repo->getQuestionsByQuiz($quizId);
    }

    /**
     * Count quiz questions
     */
    public function countQuestionsByQuiz(int $quizId): int
    {
        return $this->repo->countQuestionsByQuiz($quizId);
    }
}