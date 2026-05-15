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

      }
