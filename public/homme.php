<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Page d'accueil</title>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<nav class="bg-white shadow">
    <div class="container mx-auto flex justify-between p-4">
          <h1 class="text-xl font-bold text-indigo-600">EduQuiz</h1>

      <div class="space-x-4">
          <a href="/" class="text-gray-700">Accueil</a>
          <a href="/login" class="text-indigo-600">Connexion</a>
          <a href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded">
              Inscription
          </a>
          

    </div>
     </div>


</nav>

<section class="text-center py-20 bg-gray-50">
    <h2 class="text-4xl font-bold mb-4">Bienvenue sur EduQuiz</h2>
    <p class="text-lg text-gray-700 mb-8">
        Testez vos connaissances et apprenez de manière ludique avec nos quiz éducatifs.
    </p>
    <a href="/register" class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg">
        Commencer
    </a>



</section>
    
</body>
</html>