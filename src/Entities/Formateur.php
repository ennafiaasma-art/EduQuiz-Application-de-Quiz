<?php

declare(strict_types=1);

namespace Src\Entities;

class Formateur extends User
{


    public function __construct(

        string $name,
        string $email,
        string $password,
        int    $roleId

    )
    {
        parent::__construct($name, $email, $password, $roleId);

    }


}