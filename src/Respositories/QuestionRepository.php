<?php

declare(strict_types=1);
namespace Src\Repositories;
require_once __DIR__ . "/../../config/DB.php";

use PDO;

class QuestionRepository
{
    private $pdo;

    public function __construct() {
        $this->pdo = \DB::connect();
    }  
    
    }