<?php

declare(strict_types=1);

namespace Src\Entities;

class Result
{
    private int $id;
    private int $studentId;
    private int $quizId;
    private float $score;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): void
    {
        $this->studentId = $studentId;
    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public function setQuizId(int $quizId): void
    {
        $this->quizId = $quizId;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function setScore(float $score): void
    {
        $this->score = $score;
    }
}