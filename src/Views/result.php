<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-xl max-w-md w-full text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Score Final</h1>
        <div class="text-6xl font-black text-indigo-600 mb-6">
            <?= $score ?> <span class="text-2xl text-gray-400">/ <?= $totalQuestions ?></span>
        </div>
        <a href="index.php" class="inline-block bg-gray-800 text-white px-6 py-2 rounded-lg">Retour</a>
    </div>
</body>
</html>