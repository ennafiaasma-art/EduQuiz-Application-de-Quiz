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
require_once __DIR__ . "/../../Services/QuestionService.php";

use Src\Services\QuestionService;



$questionService = new QuestionService();

if (isset($_GET['id'])) {

    $questionService->deleteQuestion((int)$_GET['id']);

    header("Location: dashboard.php");
    exit;
}

header("Location: dashboard.php");
exit;