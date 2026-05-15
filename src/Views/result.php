<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>EduQuiz - Votre Résultat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-xl max-w-md w-full text-center">
        <div class="mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Quiz Terminé !</h1>
            <p class="text-gray-500 mt-2">Félicitations pour avoir complété le quiz.</p>
        </div>

        <div class="bg-indigo-50 rounded-xl p-6 mb-8">
            <p class="text-sm text-indigo-600 uppercase font-bold tracking-wider">Votre Score</p>
            <div class="text-5xl font-black text-indigo-700 mt-1">
                <?= $score ?> <span class="text-2xl text-indigo-400">/ <?= $totalQuestions ?></span>
            </div>
        </div>

        <div class="space-y-3">
            <a href="index.php" class="block w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>