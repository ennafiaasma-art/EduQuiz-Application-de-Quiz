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

        $message = "Question est ajoutée avec succé";

    } else {

        $message = "Tu peux pas ajouter une question";
    }
}

$allquiz = $quizService->getTeacherQuizzes(
    (int)($_SESSION['user']['id'] ?? 0)
);
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width,initial-scale=1">

    <title>Ajouter Question</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans">

<div class="flex">

    <?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

    <div class="flex-1 p-8">

        <header class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Ajouter Question</h1>
                <p class="text-sm text-[#CBD5E1] mt-2">Créer une nouvelle avec des multiples réponse</p>
            </div>
            <a href="dashboard.php" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Back</a>
        </header>

        <main class="max-w-3xl mx-auto">

            <?php if ($message): ?>
                <div class="mb-4 p-4 rounded-lg bg-gradient-to-r from-emerald-500/20 to-emerald-600/10 border border-emerald-500/30 text-emerald-300"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" class="bg-[#1E293B] p-7 rounded-xl shadow-lg border border-[#475569]/30 hover:border-[#475569]/50 transition-all duration-300">

                <!-- QUIZ -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-2">Quiz</label>
                    <?php if (!empty($allquiz)): ?>
                        <select name="quiz_id" required class="w-full px-4 py-3 bg-[#111827] border border-[#334155] text-[#F8FAFC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-transparent transition-all duration-300">
                            <?php foreach ($allquiz as $quiz): ?>
                                <option value="<?= (int)$quiz->id; ?>" class="bg-[#1E293B] text-[#F8FAFC]"><?= htmlspecialchars($quiz->id . " : " . $quiz->title); ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <select disabled class="w-full px-4 py-3 bg-[#111827] border border-[#334155] text-[#CBD5E1] rounded-lg"><option>No quizzes available</option></select>
                    <?php endif; ?>
                </div>

                <!-- QUESTION -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-2">Question</label>
                    <textarea name="question" required rows="3" class="w-full px-4 py-3 bg-[#111827] border border-[#334155] text-[#F8FAFC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-transparent transition-all duration-300 placeholder-[#CBD5E1]/50" placeholder="Enter your question"></textarea>
                </div>

                <!-- Les réponses -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-3">Answers</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php for ($i = 0; $i < 4; $i++): ?>
                            <div class="flex items-center gap-3 bg-[#111827] p-4 rounded-lg border border-[#334155] hover:border-[#475569] transition-all duration-300">
                                <input type="text" name="answers[]" placeholder="Answer <?= $i + 1; ?>" class="flex-1 px-3 py-2 bg-[#0F172A] border border-[#334155] text-[#F8FAFC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-transparent transition-all duration-300 placeholder-[#CBD5E1]/50">
                                <label class="flex items-center gap-2 text-sm text-[#CBD5E1] cursor-pointer whitespace-nowrap">
                                    <input type="radio" name="correct" value="<?= $i; ?>" class="w-4 h-4 cursor-pointer accent-[#2563EB]">
                                    Correcte
                                </label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#334155] flex items-center gap-3">
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Add Question</button>
                    <a href="dashboard.php" class="px-5 py-2.5 bg-[#1e293b] border border-[#334155] rounded-lg text-[#CBD5E1] hover:bg-[#334155] font-medium transition-all duration-300">Annuler</a>
                </div>

            </form>

        </main>

    </div>

</div>

</body>
</html>