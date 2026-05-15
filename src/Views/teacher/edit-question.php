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
require_once __DIR__ . "/../../Services/QuestionService.php";
require_once __DIR__ . "/../../Services/AnswerService.php";

use Src\Services\QuestionService;
use Src\Services\AnswerService;

$questionService = new QuestionService();
$answerService = new AnswerService();

$message = "";

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

/* =========================
   SIMPLE VERSION
========================= */

$question = null;
$answers = [];

if ($id > 0) {
    $question = $questionService->findById($id);
    $answers  = $answerService->getAnswersByQuestion($id);
}

/* =========================
   UPDATE LOGIC
========================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $questionId = (int)($_POST['id'] ?? 0);
    $answersInput = $_POST['answers'] ?? [];
    $correct = $_POST['correct'] ?? null;

    $updated = $questionService->updateQuestion(
        $questionId,
        $_POST['question'] ?? ''
    );

    if ($updated) {

        $answerService->deleteAnswersByQuestion($questionId);

        foreach ($answersInput as $index => $answerText) {

            $answerService->createAnswer(
                $questionId,
                $answerText,
                ($correct == $index)
            );
        }

        $message = "Question updated";

    } else {
        $message = "Unable to update question.";
    }

    $question = $questionService->findById($questionId);
    $answers  = $answerService->getAnswersByQuestion($questionId);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Edit Question</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans">

<div class="flex">

    <?php require_once __DIR__ . '/../../includes/navbar.php'; ?>

    <div class="flex-1 p-8">

        <header class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold tracking-tight text-white">
                    Edit Question
                </h1>

                <p class="text-sm text-[#CBD5E1] mt-2">
                    Update question and answers
                </p>
            </div>

            <a href="dashboard.php"
               class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300">

                Back

            </a>

        </header>

        <main class="max-w-2xl mx-auto">

            <?php if ($message): ?>
                <div class="mb-4 p-4 rounded-lg bg-green-500/20 border border-green-500/30 text-green-300">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST"
                  class="bg-[#1E293B] p-7 rounded-xl shadow-lg border border-[#475569]/30">

                <input type="hidden"
                       name="id"
                       value="<?= htmlspecialchars((string)($question['id'] ?? $id)); ?>">

                <div class="mb-5">

                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-2">
                        Question
                    </label>

                    <textarea
                        name="question"
                        rows="4"
                        placeholder="Edit your question"
                        class="w-full px-4 py-3 bg-[#111827] border border-[#475569]/50 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB]"><?= htmlspecialchars((string)($question['question'] ?? '')); ?></textarea>

                </div>

                <div class="mb-6">

                    <label class="block text-sm font-semibold text-[#F8FAFC] mb-3">
                        Answers
                    </label>

                    <div class="space-y-4">

                        <?php for ($i = 0; $i < 4; $i++): ?>

                            <?php
                            $currentAnswer = $answers[$i] ?? [
                                'answer_text' => '',
                                'is_correct' => 0
                            ];
                            ?>

                            <div class="flex items-center gap-3 bg-[#111827] p-4 rounded-lg border border-[#475569]/50">

                                <input
                                    type="text"
                                    name="answers[]"
                                    value="<?= htmlspecialchars((string)$currentAnswer['answer_text']); ?>"
                                    placeholder="Answer <?= $i + 1; ?>"
                                    class="flex-1 px-3 py-2 bg-[#0F172A] border border-[#475569]/50 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2563EB]">

                                <label class="flex items-center gap-2 text-sm text-[#CBD5E1]">

                                    <input
                                        type="radio"
                                        name="correct"
                                        value="<?= $i; ?>"
                                        class="accent-[#2563EB]"
                                        <?= !empty($currentAnswer['is_correct']) ? 'checked' : ''; ?>>

                                    Correct

                                </label>

                            </div>

                        <?php endfor; ?>

                    </div>

                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-[#475569]/30">

                    <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-[#2563EB] to-[#1D4ED8] text-white rounded-lg hover:from-[#1D4ED8] hover:to-[#1E40AF] transition-all duration-300">

                        Save Changes

                    </button>

                    <a href="dashboard.php"
                       class="px-5 py-2.5 bg-[#1E293B] border border-[#475569]/50 rounded-lg text-[#CBD5E1] hover:bg-[#334155]">

                        Cancel

                    </a>

                </div>

            </form>

        </main>

    </div>

</div>

</body>
</html>