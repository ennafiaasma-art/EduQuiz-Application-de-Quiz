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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $code = $service->createQuiz(
        $_POST['title'] ?? '',
        $_POST['description'] ?? '',
        (int)($_SESSION['user']['id'] ?? 0)
    );

    if ($code) {
        $message = "Quiz created successfully. Access Code : " . $code;
    } else {
        $message = "Failed to create quiz. Please try again.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Create Quiz</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome (FIXED) -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans">

<div class="flex">

    <?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

    <div class="flex-1 p-8">

        <header class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Create Quiz</h1>
                <p class="text-sm text-[#CBD5E1] mt-2">Create a new quiz for your students</p>
            </div>
            <a href="dashboard.php" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Back to dashboard</a>
        </header>

        <main class="max-w-3xl mx-auto">

            <?php if ($message): ?>
                <div class="mb-4 p-4 rounded-lg bg-[#1e3a8a] text-white"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" class="bg-[#1E293B] p-7 rounded-xl shadow-lg border border-[#475569]/30 hover:border-[#475569]/50 transition-all duration-300">

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-2">Quiz Title</label>
                    <input type="text" name="title" required class="w-full px-4 py-3 bg-[#111827] border border-[#475569]/50 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-transparent transition-all duration-300 placeholder-[#CBD5E1]/50" placeholder="Enter quiz title">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 bg-[#111827] border border-[#475569]/50 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-transparent transition-all duration-300 placeholder-[#CBD5E1]/50" placeholder="Enter quiz description"></textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Create Quiz</button>
                    <a href="dashboard.php" class="px-5 py-2.5 bg-[#1e293b] border border-[#475569]/50 rounded-lg text-[#CBD5E1] hover:bg-[#334155] hover:border-[#475569] text-sm font-medium transition-all duration-300">Cancel</a>
                </div>

            </form>

        </main>

    </div>

</div>

</body>
</html>