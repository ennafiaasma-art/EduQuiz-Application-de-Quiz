<?php

declare(strict_types=1);

namespace Src\Entities;

class Formateur extends User
{


    public function __construct(
        int    $id,
        string $name,
        string $email,
        string $password

    )
    {
        parent::__construct($id, $name, $email, $password);


    }


}