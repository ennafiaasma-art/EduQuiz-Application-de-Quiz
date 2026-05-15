<?php
declare(strict_types=1);

namespace Src\Services;

use Src\Repositories\QuizRepository;
use Src\Entities\Quiz;

require_once __DIR__ . "/../../config/DB.php";
require_once __DIR__ . "/../Repositories/QuizRepository.php";
require_once __DIR__ . "/../Entities/Quiz.php";

class QuizService
{
    private QuizRepository $repo;

    public function __construct()
    {
        $this->repo = new QuizRepository();
    }


}