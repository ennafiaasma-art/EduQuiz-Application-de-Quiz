 
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-indigo-600"><?= $quiz['title'] ?></h2>
    
    <form action="index.php?action=submit_quiz" method="POST">
        <input type="hidden" name="quiz_id" value="<?= $quiz['id'] ?>">
        
        <?php foreach ($questions as $q): ?>
            <div class="mb-8 p-4 border-l-4 border-indigo-500 bg-gray-50">
                <p class="font-semibold text-lg mb-4"><?= htmlspecialchars($q['text']) ?></p>
                <div class="space-y-2">
                    <?php foreach ($q['answers'] as $ans): ?>
                        <label class="flex items-center space-x-3 p-2 hover:bg-indigo-100 rounded cursor-pointer">
                            <input type="radio" name="answer[<?= $q['id'] ?>]" value="<?= $ans['id'] ?>" class="form-radio h-5 w-5 text-indigo-600" required>
                            <span><?= htmlspecialchars($ans['text']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
            Soumettre le Quiz
        </button>
    </form>
</div>