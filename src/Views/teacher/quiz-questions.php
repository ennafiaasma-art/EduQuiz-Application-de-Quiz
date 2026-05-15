<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}

if (($_SESSION['user']['role_name'] ?? '') !== 'teacher') {
    die('Access denied');
}

require_once __DIR__ . '/../../../config/DB.php';
require_once __DIR__ . '/../../Services/QuizService.php';
require_once __DIR__ . '/../../Services/QuestionService.php';
require_once __DIR__ . '/../../Services/AnswerService.php';

use Src\Services\QuizService;
use Src\Services\QuestionService;
use Src\Services\AnswerService;

$questionService = new QuestionService();
$answerService = new AnswerService();
$quizService = new QuizService();

$quizId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$quiz = $quizId > 0 ? $quizService->getQuizById($quizId) : null;
$questions = $quizId > 0 ? $questionService->getQuestionsByQuiz($quizId) : [];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quiz Questions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .content-max { max-width: 1100px; }
    </style>
</head>
<body class="bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans">
<div class="flex">

    <?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

    <div class="flex-1 p-8">

        <header class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Quiz Questions</h1>
                <p class="text-sm text-[#CBD5E1] mt-2">Review and manage all questions</p>
            </div>
            <a id="s6a9vz" href="dashboard.php" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Back</a>
        </header>

        <main class="max-w-5xl mx-auto">

            <?php if (!$quiz): ?>
                <div class="bg-[#1E293B] rounded-xl shadow-lg border border-[#475569]/30 p-6">
                    <p class="text-[#CBD5E1]">Quiz not found.</p>
                </div>
            <?php else: ?>
                <div class="bg-[#1E293B] rounded-xl shadow-lg border border-[#475569]/30 p-6 mb-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold text-white"><?= htmlspecialchars($quiz->title); ?></h2>
                            <p class="mt-2 text-sm text-[#CBD5E1]"><?= htmlspecialchars($quiz->description); ?></p>
                        </div>
                        <span class="inline-flex w-fit items-center rounded-lg bg-gradient-to-r from-[#2563EB]/20 to-[#60A5FA]/10 text-[#60A5FA] px-4 py-2 text-xs font-semibold border border-[#2563EB]/30 shadow-lg shadow-blue-500/10">Quiz ID: <?= (int)$quiz->id; ?></span>
                    </div>
                </div>

                <div class="space-y-4">
                    <?php if (empty($questions)): ?>
                        <div class="bg-[#1E293B] rounded-xl shadow-lg border border-[#475569]/30 p-6">
                            <p class="text-[#CBD5E1]">No questions found for this quiz</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($questions as $question): ?>
                            <?php $answers = $answerService->getAnswersByQuestion((int)$question['id']); ?>
                            <div class="bg-[#1E293B] rounded-xl shadow-lg border border-[#475569]/30 p-6 hover:shadow-2xl hover:border-[#475569]/60 transition-all duration-300">
                                <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                    <p class="text-base font-medium text-[#F8FAFC] leading-relaxed"><?= htmlspecialchars($question['question']); ?></p>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <a href="edit-question.php?id=<?= (int)$question['id']; ?>" class="px-4 py-2 text-xs rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 text-white hover:from-amber-600 hover:to-amber-700 transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg shadow-amber-500/20">Edit</a>
                                        <a href="delete-question.php?id=<?= (int)$question['id']; ?>" class="px-4 py-2 text-xs rounded-lg bg-red-900/20 text-red-400 hover:bg-red-900/40 transition-all duration-300 border border-red-900/40 font-semibold">Delete</a>
                                    </div>
                                </div>

                                <div class="mt-5 space-y-3 border-t border-[#475569]/30 pt-5">
                                    <?php if (empty($answers)): ?>
                                        <div class="text-sm text-[#CBD5E1]">No answers found</div>
                                    <?php else: ?>
                                        <?php foreach ($answers as $answer): ?>
                                            <div class="flex flex-col gap-2 rounded-lg border border-[#475569]/50 bg-[#111827] px-4 py-3 md:flex-row md:items-center md:justify-between hover:border-[#475569] transition-all duration-300">
                                                <p class="text-sm text-[#F8FAFC]"><?= htmlspecialchars($answer['answer_text']); ?></p>
                                                <?php if (!empty($answer['is_correct'])): ?>
                                                    <span class="inline-flex w-fit items-center rounded-lg bg-emerald-500/20 px-3 py-1 text-xs font-semibold text-emerald-300 border border-emerald-500/30">✓ Correct</span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </main>

    </div>

</div>
</body>
</html>
