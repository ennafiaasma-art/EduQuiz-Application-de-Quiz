<?php

declare(strict_types=1);

namespace Src\Entities;

class Student extends User
{
    private string $studentCode;

    public function __construct(
        int $id,
        string $name,
        string $email,
        string $password,
        string $studentCode
    ) {
        parent::__construct($id, $name, $email, $password);

        $this->studentCode = $studentCode;
    }

    public function getStudentCode(): string
    {
        return $this->studentCode;
    }

    public function setStudentCode(string $studentCode): void
    {
        $this->studentCode = $studentCode;
    }
}