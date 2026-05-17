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

$quizService = new QuizService();
$QuestionService = new QuestionService();
$AnswerService = new AnswerService();


$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $answers = $_POST['answers'] ?? [];
    $correct = $_POST['correct'] ?? null;

    $questionId = $questionService->createQuestion(
        (int)($_POST['quiz_id'] ?? 0),
        $_POST['question'] ?? ''
    );

    if ($questionId > 0) {

        foreach ($answers as $index => $answer) {

            $isCorrect = ($correct == $index);

            $answerService->createAnswer(
                $questionId,
                $answer,
                $isCorrect
            );
        }

        $message = "Question added successfully";

    } else {

        $message = "Unable to add question";
    }
}

$allquiz = $quizService->getTeacherQuizzes(
    (int)($_SESSION['user']['id'] ?? 0)
);
?>