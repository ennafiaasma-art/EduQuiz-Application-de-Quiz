<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>EduQuiz - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h1 class="text-2xl font-bold mb-6 text-center">Bienvenue sur EduQuiz</h1>
        <form action="index.php?action=start_quiz" method="POST">
            <label class="block mb-2">Entrez le code du Quiz :</label>
            <input type="text" name="quiz_code" class="w-full p-2 border rounded mb-4" required>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Lancer le Quiz
            </button>
        </form>
    </div>
</body>
</html>