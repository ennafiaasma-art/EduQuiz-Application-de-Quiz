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

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$quiz = $id > 0 ? $service->getQuizById($id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updated = $service->updateQuiz(
        (int)($_POST['id'] ?? 0),
        $_POST['title'] ?? '',
        $_POST['description'] ?? ''
    );

    if ($updated) {
       $message = "Quiz modifié avec succès";
    }
  $userId = (int)$_SESSION['user']['id'];

$quiz = $service->getQuizById($id);

if (!$quiz || $quiz->teacher_id !== $userId) {
    die('accés non autorisé');
}
}
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans">

<div class="flex">

    <?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

    <div class="flex-1 p-8">

        <header class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">Modifier le Quiz</h1>
                <p class="text-sm text-[#CBD5E1] mt-2">Modifier les information du Quiz</p>
            </div>
            <a href="dashboard.php" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Back</a>
        </header>

        <main class="max-w-3xl mx-auto">

            <?php if ($message): ?>
                <div class="mb-4 p-4 rounded-lg bg-gradient-to-r from-emerald-500/20 to-emerald-600/10 border border-emerald-500/30 text-emerald-300"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form method="POST" class="bg-[#1E293B] p-7 rounded-xl shadow-lg border border-[#475569]/30 hover:border-[#475569]/50 transition-all duration-300">
                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($quiz->id ?? $id)); ?>">

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-2">Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars((string)($quiz->title ?? '')); ?>" class="w-full px-4 py-3 bg-[#111827] border border-[#334155] text-[#F8FAFC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-transparent transition-all duration-300 placeholder-[#CBD5E1]/50" placeholder="Quiz Title">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 bg-[#111827] border border-[#334155] text-[#F8FAFC] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-transparent transition-all duration-300 placeholder-[#CBD5E1]/50" placeholder="Quiz Description"><?= htmlspecialchars((string)($quiz->description ?? '')); ?></textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-[#334155]">
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300 transform hover:scale-105 shadow-lg shadow-blue-500/20 font-medium">Sauvegarder les modifications</button>
                    <a href="dashboard.php" class="px-5 py-2.5 bg-[#1e293b] border border-[#334155] rounded-lg text-[#CBD5E1] hover:bg-[#334155] font-medium transition-all duration-300">Annuler</a>
                </div>
            </form>

        </main>

    </div>

</div>

</body>
</html>