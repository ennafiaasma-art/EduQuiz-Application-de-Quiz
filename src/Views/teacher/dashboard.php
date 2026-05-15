<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['user']['role_name'] !== 'teacher') {
    die('Access denied');
}

require_once __DIR__ . "/../../../config/DB.php";
require_once __DIR__ . "/../../Services/QuizService.php";
require_once __DIR__ . "/../../Services/QuestionService.php";

use Src\Services\QuizService;
use Src\Services\QuestionService;

$quizService = new QuizService();
$questionService = new QuestionService();

$quizzes = $quizService->getTeacherQuizzes((int)$_SESSION['user']['id']);
$totalQuizzes = count($quizzes);
$questionCounts = [];
$totalQuestions = 0;

foreach ($quizzes as $quiz) {
    $count = $questionService->countQuestionsByQuiz((int)$quiz->id);
    $questionCounts[(int)$quiz->id] = $count;
    $totalQuestions += $count;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Teacher Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .content-max {
            max-width: 1100px;
        }
    </style>
</head>

<body class="bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans">

<div class="flex">

    <?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

    <!-- Main -->
    <div class="flex-1 p-8">

        <!-- Header -->
        <header class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Welcome, <?= htmlspecialchars($_SESSION['user']['name']); ?>
                </h1>
                <p class="text-sm text-[#CBD5E1] mt-2">
                    Overview of your quizzes
                </p>
            </div>

            <a href="../auth/logout.php"
               class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-red-500/20 font-medium">
                Logout
            </a>

        </header>

        <main class="content-max mx-auto">

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <div class="bg-[#1E293B] rounded-xl p-6 shadow-lg border border-[#475569]/30 hover:shadow-2xl hover:border-[#475569]/60 transition-all duration-300 transform hover:-translate-y-1 hover:bg-[#334155]/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#2563EB] to-[#1D4ED8] text-white rounded-lg flex items-center justify-center text-xl shadow-lg">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div>
                            <p class="text-sm text-[#CBD5E1]">Total Quizzes</p>
                            <p class="text-2xl font-bold text-white mt-1"><?= $totalQuizzes; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#1E293B] rounded-xl p-6 shadow-lg border border-[#475569]/30 hover:shadow-2xl hover:border-[#475569]/60 transition-all duration-300 transform hover:-translate-y-1 hover:bg-[#334155]/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#10B981] to-[#059669] text-white rounded-lg flex items-center justify-center text-xl shadow-lg">
                            <i class="fa-solid fa-circle-question"></i>
                        </div>
                        <div>
                            <p class="text-sm text-[#CBD5E1]">Total Questions</p>
                            <p class="text-2xl font-bold text-white mt-1"><?= $totalQuestions; ?></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Quizzes -->
            <div class="bg-[#1E293B] rounded-xl shadow-lg border border-[#475569]/30 p-6">

                <div class="flex justify-between items-center mb-6">

                    <h3 class="text-xl font-bold text-white">
                        My Quizzes
                    </h3>

                    <a href="create-quiz.php"
                       class="bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white px-5 py-2.5 rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">
                        <i class="fa-solid fa-plus mr-2"></i> Create Quiz
                    </a>

                </div>

                <?php if (empty($quizzes)): ?>

                    <p class="text-[#CBD5E1]">No quizzes found</p>

                <?php else: ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <?php foreach ($quizzes as $quiz): ?>

                            <?php
                            $questionCount = (int)($questionCounts[(int)$quiz->id] ?? 0);
                            ?>

                            <div class="bg-[#1E293B] border border-[#475569]/30 rounded-xl p-6 shadow-lg hover:shadow-2xl hover:border-[#475569]/60 transition-all duration-300 transform hover:-translate-y-1 hover:bg-[#334155]/40">

                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-2">
                                            <?= htmlspecialchars($quiz->title) ?>
                                        </h4>
                                        <p class="text-[#CBD5E1] mb-4 leading-relaxed">
                                            <?= htmlspecialchars($quiz->description) ?>
                                        </p>
                                    </div>

                                    <div class="text-right shrink-0">
                                        <span class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2563EB]/20 to-[#60A5FA]/10 text-[#60A5FA] px-3 py-1.5 rounded-lg text-sm font-semibold border border-[#2563EB]/30">
                                            <i class="fa-solid fa-key"></i>
                                            <?= htmlspecialchars($quiz->accesscode) ?>
                                        </span>
                                        <div class="mt-3 text-sm text-[#CBD5E1]">
                                            <?= $questionCount ?> Questions
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-3 mt-5 pt-4 border-t border-[#475569]/30">

                                    <a href="edit-quiz.php?id=<?= $quiz->id ?>"
                                       class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-4 py-2 rounded-lg hover:from-amber-600 hover:to-amber-700 transition-all duration-300 transform hover:scale-105 text-sm font-medium shadow-lg shadow-amber-500/20">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>

                                    <a href="delete-quiz.php?id=<?= $quiz->id ?>"
                                       class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600/80 to-red-700/80 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 text-sm font-medium shadow-lg shadow-red-500/10">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>

                                    <a href="quiz-questions.php?id=<?= $quiz->id ?>"
                                       class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-lg hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 text-sm font-medium shadow-lg shadow-emerald-500/20">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </main>

    </div>

</div>

</body>
</html>