<?php

declare(strict_types=1);

namespace Src\Entities;

class Formateur extends User
{
    private string $specialty;

    public function __construct(
        int    $id,
        string $name,
        string $email,
        string $password,
        string $specialty
    )
    {
        parent::__construct($id, $name, $email, $password);

        $this->specialty = $specialty;
    }

    public function getSpecialty(): string
    {
        return $this->specialty;
    }

    public function setSpecialty(string $specialty): void
    {
        $this->specialty = $specialty;
    }
}