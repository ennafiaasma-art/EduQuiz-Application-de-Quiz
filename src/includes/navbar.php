<?php
// Reusable sidebar/navbar for Teacher pages
$curr = basename($_SERVER['PHP_SELF']);
function navClass($page, $base = false) {
    global $curr;
    if ($curr === $page) {
        return 'flex items-center gap-3 px-4 py-3 rounded-lg bg-gradient-to-r from-[#2563EB]/20 to-[#60A5FA]/10 text-[#60A5FA] border border-[#2563EB]/30 transition-all duration-300 transform font-medium shadow-lg shadow-[#2563EB]/5';
    }
    return 'flex items-center gap-3 px-4 py-3 rounded-lg text-[#CBD5E1] hover:bg-[#334155]/40 hover:text-[#60A5FA] transition-all duration-300 border border-transparent hover:border-[#475569]/30';
}
?>
<aside class="w-72 bg-gradient-to-b from-[#111827] to-[#0F172A] text-white min-h-screen shadow-2xl border-r border-[#475569]/30">
    <div class="p-6 border-b border-[#475569]/30 bg-gradient-to-b from-[#1E293B] to-transparent">
        <h2 class="text-2xl font-bold tracking-tight bg-gradient-to-r from-[#60A5FA] to-[#2563EB] bg-clip-text text-transparent">EduQuiz</h2>
        <p class="text-sm text-[#CBD5E1] mt-1">Teacher Panel</p>
    </div>
    <nav class="p-4 space-y-2">
        <a href="dashboard.php" class="<?= navClass('dashboard.php'); ?>"><i class="fa-solid fa-gauge"></i><span>Dashboard</span></a>
        <a href="create-quiz.php" class="<?= navClass('create-quiz.php'); ?>"><i class="fa-solid fa-plus"></i><span>Create Quiz</span></a>
        <a href="add-question.php" class="<?= navClass('add-question.php'); ?>"><i class="fa-solid fa-circle-question"></i><span>Add Question</span></a>
        <a href="my-quizzes.php" class="<?= navClass('my-quizzes.php'); ?>"><i class="fa-solid fa-list"></i><span>My Quizzes</span></a>
    </nav>
</aside>
