<?php

declare(strict_types=1);

namespace Src\Entities;

class Quiz
{
     
    private string $title;
    private string $description;
    private string $accessCode;
    private int $teacherId;

    public function __construct( string $title, string $description, string $accessCode, int $teacherId)
    {
       
        $this->title = $title;
        $this->description = $description;
        $this->accessCode = $accessCode;
        $this->teacherId = $teacherId;
    }

 
 

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAccessCode(): string
    {
        return $this->accessCode;
    }

    public function setAccessCode(string $accessCode): void
    {
        $this->accessCode = $accessCode;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function setTeacherId(int $teacherId): void
    {
        $this->teacherId = $teacherId;
    }
}