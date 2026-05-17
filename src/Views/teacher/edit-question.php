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

$message = "";

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$quiz = $id > 0 ? $service->getQuizById($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated = $service->updateQuiz(
        (int)($_POST['id'] ?? 0),
        $_POST['title'] ?? '',
        $_POST['description'] ?? ''
    );

    if ($updated) {
        $message = "La question est modifier avec succé";
    }
    $quiz = $service->getQuizById((int)($_POST['id'] ?? 0));
}
?>