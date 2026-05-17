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

use Src\Services\QuizService;

$service = new QuizService();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $quizId = (int)($_POST['id'] ?? 0);

    $service->deleteQuiz($quizId);
}

header("Location: dashboard.php");
exit;