<?php

declare(strict_types=1);

namespace Src\Entities;

class Question
{
    private int $id;
    private string $text;
    private int $quizId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getQuizId(): int
    {
        return $this->quizId;
    }

    public function setQuizId(int $quizId): void
    {
        $this->quizId = $quizId;
    }
}