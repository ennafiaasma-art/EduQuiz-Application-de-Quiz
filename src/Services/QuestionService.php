<?php

declare(strict_types=1);

namespace Src\Services;

use Src\Repositories\QuestionRepository;

require_once __DIR__ . "/../Repositories/QuestionRepository.php";

class QuestionService
{
    private QuestionRepository $repo;

    public function __construct()
    {
        $this->repo = new QuestionRepository();
    }
 }