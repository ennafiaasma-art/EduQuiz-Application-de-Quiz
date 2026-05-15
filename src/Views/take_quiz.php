<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>EduQuiz - <?= htmlspecialchars($quiz->title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen py-10">

    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-sm p-8 mb-8 border-t-4 border-indigo-600">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2"><?= htmlspecialchars($quiz->title) ?></h1>
            <p class="text-gray-500 italic"><?= htmlspecialchars($quiz->description ?? 'Répondez à toutes les questions.') ?></p>
        </div>

        <form action="index.php?action=submit_quiz" method="POST" class="space-y-6">
            <input type="hidden" name="quiz_id" value="<?= $quiz->id ?>">

            <?php 
            // Logic sghira bach n-groupiw answers l-kol question
            $groupedQuestions = [];
            foreach ($questions as $row) {
                $groupedQuestions[$row->q_id]['text'] = $row->question;
                $groupedQuestions[$row->q_id]['answers'][] = [
                    'id' => $row->a_id,
                    'text' => $row->answer_text
                ];
            }

            $qNum = 1;
            foreach ($groupedQuestions as $qId => $data): ?>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-start mb-4">
                            <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold mr-3 mt-1">
                                <?= $qNum++ ?>
                            </span>
                            <p class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($data['text']) ?></p>
                        </div>

                        <div class="grid grid-cols-1 gap-3 ml-11">
                            <?php foreach ($data['answers'] as $ans): ?>
                                <label class="group relative flex items-center p-4 border-2 border-gray-100 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition-all">
                                    <input type="radio" name="answer[<?= $qId ?>]" value="<?= $ans['id'] ?>" class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                    <span class="ml-4 text-gray-700 group-hover:text-indigo-700 font-medium"><?= htmlspecialchars($ans['text']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pt-6">
                <button type="submit" class="w-full bg-indigo-600 text-white py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-200">
                    ✓ Valider mes réponses
                </button>
            </div>
        </form>
    </div>

</body>
</html>