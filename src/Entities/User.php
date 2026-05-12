<?php
declare(strict_types=1);

namespace Src\Entities;

abstract class User
{

    protected string $name;
    protected string $email;
    protected string $password;
    protected int $roleId;

    public function __construct(

        string $name,
        string $email,
        string $password,
        int    $roleId
    )
    {
        
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId;
    }

    // ================= GETTERS =================


    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    // ================= SETTERS =================

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }
}