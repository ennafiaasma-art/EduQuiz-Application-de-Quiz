<?php

declare(strict_types=1);

namespace Src\Services;

use Src\Repositories\AnswerRepository;

require_once __DIR__ . "/../Repositories/AnswerRepository.php";


class AnswerService
{
    private AnswerRepository $repo;

    public function __construct()
    {
        $this->repo = new AnswerRepository();
    }



     public function createAnswer(
        int $questionId,
        string $answer,
        bool $isCorrect
    ): bool {
        if ($questionId <= 0 || empty(trim($answer))) {
            return false;
        }

        try {
            return $this->repo->create(
                $questionId,
                trim($answer),
                $isCorrect
            );
        } catch (\Throwable $e) {
            return false;
        }
    }

      }
