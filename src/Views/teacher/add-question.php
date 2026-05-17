<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if (($_SESSION['user']['role_name'] ?? '') !== 'teacher') {
    die('Access denied');
}

require_once __DIR__ . "/../../../config/DB.php";
require_once __DIR__ . "/../../Services/QuizService.php";
require_once __DIR__ . "/../../Services/QuestionService.php";
require_once __DIR__ . "/../../Services/AnswerService.php";

use Src\Services\QuizService;
use Src\Services\QuestionService;
use Src\Services\AnswerService;
