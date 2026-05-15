<?php
namespace App\Entities;

class Question {
    private int $id;
    private string $questionText;
    private array $answers = []; 

    public function __construct(int $id, string $text) {
        $this->id = $id;
        $this->questionText = $text;
    }

    public function getId(): int { return $this->id; }
    public function getQuestionText(): string { return $this->questionText; }

    public function addAnswer($answer): void {
        $this->answers[] = $answer;
    }
    public function getAnswers(): array { return $this->answers; } 
}