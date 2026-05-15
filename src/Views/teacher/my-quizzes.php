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

use Src\Services\QuizService;

$quizService = new QuizService();
$quizzes = $quizService->getTeacherQuizzes((int)$_SESSION['user']['id']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My Quizzes</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans">

<div class="flex">



    <div class="flex-1 p-8">

        <header class="flex items-center justify-between mb-6">
            <div>
            <h1 class="text-3xl font-bold tracking-tight text-white">My Quizzes</h1>
                <p class="text-sm text-[#CBD5E1] mt-2">All quizzes created by you</p>
            </div>
            <a href="dashboard.php" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Back</a>
        </header>

        <main class="max-w-5xl mx-auto">

            <?php if (empty($quizzes)): ?>
                <div class="bg-[#1e293b] p-6 rounded-xl shadow-lg border border-[#475569]/30 text-[#CBD5E1]">No quizzes found.</div>
            <?php else: ?>
                <div class="grid gap-4">
                    <?php foreach ($quizzes as $quiz): ?>
                        <div class="bg-[#1E293B] p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-[#475569]/30 hover:border-[#475569]/60 transform hover:-translate-y-1 hover:bg-[#334155]/40">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-white"><?= htmlspecialchars($quiz->title); ?></h2>
                                    <p class="text-sm text-[#CBD5E1] mt-2"><?= htmlspecialchars($quiz->description); ?></p>
                                    <div class="mt-4">
                                        <span class="text-xs bg-gradient-to-r from-[#2563EB]/20 to-[#60A5FA]/10 text-[#60A5FA] px-3 py-1.5 rounded-lg border border-[#2563EB]/30 font-semibold">Access: <?= htmlspecialchars($quiz->accesscode); ?></span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-3">
                                    <div class="text-sm text-[#CBD5E1]"><?= ''; ?></div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="edit-quiz.php?id=<?= (int)$quiz->id; ?>" class="px-3 py-2 bg-[#1e293b] border border-amber-500/40 rounded-lg text-amber-400 hover:bg-amber-500/10 hover:border-amber-500/60 text-xs font-medium transition-all duration-300">Edit</a>
                                        <a href="delete-quiz.php?id=<?= (int)$quiz->id; ?>" class="px-3 py-2 bg-red-900/20 text-red-400 rounded-lg hover:bg-red-900/40 text-xs font-medium transition-all duration-300 border border-red-900/40">Delete</a>
                                        <a href="quiz-questions.php?id=<?= (int)$quiz->id; ?>" class="px-3 py-2 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] text-xs font-medium transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </main>

    </div>

</div>

</body>
</html>