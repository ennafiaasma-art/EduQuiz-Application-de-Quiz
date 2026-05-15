<?php

session_start();

$baseDir = dirname(__DIR__);

if (isset($_SESSION['user'])) {
    if (($_SESSION['user']['role_name'] ?? '') === 'teacher') {
        header('Location: ../src/Views/teacher/dashboard.php');
    } else {
        header('Location: ../src/Views/student/dashboard.php');
    }
    exit;
}

require_once $baseDir . '/src/Repositories/QuizRepository.php';

$quizRepo = new \Src\Repositories\QuizRepository();
$action = $_GET['action'] ?? 'home';
$error = null;

if ($action === 'start_quiz') {
    $code = trim($_POST['quiz_code'] ?? '');
    $quiz = $quizRepo->findByCode($code);

    if ($quiz) {
        $quizId = (int)($quiz->id ?? 0);
        $questions = $quizRepo->getFullQuizData($quizId);
        include $baseDir . '/src/Views/take_quiz.php';
        exit;
    }

    $error = 'Code incorrect !';
}

include $baseDir . '/src/Views/home.php';
