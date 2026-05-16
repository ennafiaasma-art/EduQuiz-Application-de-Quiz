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
require_once $baseDir . '/src/Services/QuizService.php';

$quizRepo = new \Src\Repositories\QuizRepository();
$action = $_GET['action'] ?? 'home';
$error = null;

if ($action === 'start_quiz') {
    $code = trim($_POST['quiz_code'] ?? '');
    $quiz = $quizRepo->findByCode($code);

    if ($quiz) {
        
        $questions = $quizRepo->getFullQuizData((int)$quiz->id);
        include $baseDir . '/src/Views/take_quiz.php';
        exit;
    }

    $error = 'Code incorrect !';
} 

elseif ($action === 'submit_quiz') {
    $quizId = (int)($_POST['quiz_id'] ?? 0);
    $userAnswers = $_POST['answer'] ?? []; 

    $quizService = new \Src\Services\QuizService();
    
    
    $db = \DB::connect();
    $stmt = $db->prepare("SELECT id, question_id FROM answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = ?) AND is_correct = 1");
    $stmt->execute([$quizId]);
    $correctRows = $stmt->fetchAll(PDO::FETCH_OBJ);

    
    $correctAnswers = [];
    foreach ($correctRows as $row) {
        $correctAnswers[$row->question_id] = $row->id;
    }

    
    $score = $quizService->calculateScore($userAnswers, $correctAnswers);
    $totalQuestions = count($correctAnswers);

    
    include $baseDir . '/src/Views/result.php';
    exit;
}


include $baseDir . '/src/Views/home.php';