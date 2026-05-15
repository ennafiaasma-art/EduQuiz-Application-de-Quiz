<?php

$baseDir = dirname(__DIR__);

require_once $baseDir . '/config/Database.php';
require_once $baseDir . '/src/Entities/Question.php'; 
require_once $baseDir . '/src/Repositories/QuizRepository.php';

use App\Repositories\QuizRepository;

$db = (new Database())->getConnection();
$quizRepo = new QuizRepository($db);

$action = $_GET['action'] ?? 'home';

if ($action === 'start_quiz') {
    $code = $_POST['quiz_code'] ?? '';
    $quiz = $quizRepo->findByCode($code);

    if ($quiz) {
        $questions = $quizRepo->getFullQuizData($quiz->id);
        include $baseDir . '/src/Views/take_quiz.php';
    } else {
        echo "Code incorrect !";
    }
} else {
   
    include $baseDir . '/src/Views/home.php';
}
elseif ($action ==='submit_quiz'){
    $quizId = $_POST['quiz_id'] ?? 0;
    $userAnswers = $_POST['answers'] ?? [];

    $stmt = $db->prepare("SELECT id, question_id FROM answers WHERE question_id IN (SELECT id FROM questions WHERE quiz_id = :quiz_id) AND is_correct = 1");
    $stmt->execute(['quiz_id' =>$quizId]);
    $correctAnswersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $correctAnswers = [];
    foreach ($correctAnswersData as $row){
        $correctAnswers[$row['question_id']] = $row['id'];
        
    }
}
?>