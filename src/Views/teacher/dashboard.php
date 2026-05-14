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
require_once __DIR__ . "/../../Repositories/QuizRepository.php";

use Src\Repositories\QuizRepository;

$quizRepo = new QuizRepository();
$pdo = \DB::connect();

$quizzes = $quizRepo->allByTeacher((int)$_SESSION['user']['id']);
$totalQuizzes = count($quizzes);

$stmt = $pdo->prepare("
    SELECT COUNT(qs.id) AS total
    FROM questions qs
    JOIN quizzes q ON qs.quiz_id = q.id
    WHERE q.teacher_id = ?
");

$stmt->execute([(int)$_SESSION['user']['id']]);

$totalQuestions = (int)$stmt->fetch(PDO::FETCH_OBJ)->total;

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

<body class="bg-indigo-50 text-gray-800 min-h-screen">

<div class="flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg min-h-screen">

        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-indigo-600">
                EduQuiz
            </h2>
            <p class="text-sm text-gray-500">Teacher Panel</p>
        </div>

        <nav class="p-6 space-y-2">

            <a href="dashboard.php"
               class="flex items-center gap-3 px-3 py-2 rounded-lg bg-indigo-50 text-indigo-700">
                <i class="fa-solid fa-gauge"></i>
                Dashboard
            </a>

            <a href="create-quiz.php"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-50">
                <i class="fa-solid fa-plus"></i>
                Create Quiz
            </a>

            <a href="add-question.php"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-50">
                <i class="fa-solid fa-circle-question"></i>
                Add Question
            </a>

            <a href="my-quizzes.php"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-indigo-50">
                <i class="fa-solid fa-list"></i>
                My Quizzes
            </a>

        </nav>
    </aside>

    <!-- Main -->
    <div class="flex-1 p-8">

        <!-- Header -->
        <header class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome, <?= htmlspecialchars($_SESSION['user']['name']); ?>
                </h1>
                <p class="text-sm text-gray-500">
                    Overview of your quizzes
                </p>
            </div>

            <a href="../auth/logout.php"
               class="px-4 py-2 bg-white rounded-lg shadow hover:bg-gray-100 text-sm">
                Logout
            </a>

        </header>

        <main class="content-max mx-auto">

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                <div class="bg-white rounded-xl p-5 shadow">
                    <p class="text-sm text-gray-500">Total Quizzes</p>
                    <p class="text-2xl font-semibold text-indigo-600 mt-2">
                        <i class="fa-solid fa-book"></i>
                        <?= $totalQuizzes; ?>
                    </p>
                </div>

                <div class="bg-white rounded-xl p-5 shadow">
                    <p class="text-sm text-gray-500">Total Questions</p>
                    <p class="text-2xl font-semibold text-indigo-600 mt-2">
                        <i class="fa-solid fa-circle-question"></i>
                        <?= $totalQuestions; ?>
                    </p>
                </div>

            </div>

            <!-- Quizzes -->
            <div class="bg-white rounded shadow p-6">

                <div class="flex justify-between items-center mb-5">

                    <h3 class="text-xl font-bold">
                        My Quizzes
                    </h3>

                    <a href="create-quiz.php"
                       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        <i class="fa-solid fa-plus"></i> Create Quiz
                    </a>

                </div>

                <?php if (empty($quizzes)): ?>

                    <p class="text-gray-500">No quizzes found</p>

                <?php else: ?>

                    <div class="space-y-4">

                        <?php foreach ($quizzes as $quiz): ?>

                            <?php
                            $stmt = $pdo->prepare("
                                SELECT COUNT(*) AS total
                                FROM questions
                                WHERE quiz_id = ?
                            ");

                            $stmt->execute([$quiz->id]);

                            $questionCount = (int)$stmt
                                    ->fetch(PDO::FETCH_OBJ)
                                    ->total;
                            ?>

                            <div class="border rounded p-5">

                                <h4 class="text-lg font-bold mb-2">
                                    <?= htmlspecialchars($quiz->title) ?>
                                </h4>

                                <p class="text-gray-600 mb-3">
                                    <?= htmlspecialchars($quiz->description) ?>
                                </p>

                                <div class="flex gap-3 mb-4">

                                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm">
                                        <i class="fa-solid fa-key"></i>
                                        <?= htmlspecialchars($quiz->accesscode) ?>
                                    </span>

                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded text-sm">
                                        <?= $questionCount ?> Questions
                                    </span>

                                </div>

                                <div class="flex gap-3">

                                    <a href="edit-quiz.php?id=<?= $quiz->id ?>"
                                       class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>

                                    <a href="delete-quiz.php?id=<?= $quiz->id ?>"
                                       class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-sm">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>

                                    <a href="quiz-questions.php?id=<?= $quiz->id ?>"
                                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                                        <i class="fa-solid fa-eye"></i> Show Questions
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