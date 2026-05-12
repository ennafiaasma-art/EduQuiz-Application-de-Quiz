<?php

namespace Src\Services;
require_once __DIR__ . "/../../config/DB.php";

class AuthService
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = \DB::connect();
    }

    public function register()
    {


    }

}