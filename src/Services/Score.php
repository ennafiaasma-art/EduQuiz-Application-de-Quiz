<?php

require_once __DIR__ . "/../../config/DB.php";

$pdo = DB::connect();


$sql = "
SELECT 
    q.id AS question_id,
    q.question,
    a.id AS answer_id,
    a.answer_text,
    a.is_correct
FROM questions q
JOIN answers a ON a.question_id = q.id
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


$questions = [];

foreach ($data as $row) {
    $qid = $row['question_id'];

    if (!isset($questions[$qid])) {
        $questions[$qid] = [
            'id' => $qid,
            'question' => $row['question'],
            'answers' => []
        ];
    }

    $questions[$qid]['answers'][] = [
        'id' => $row['answer_id'],
        'text' => $row['answer_text'],
        'is_correct' => $row['is_correct']
    ];
}


class QuizCorrectionService
{
    public function corriger(array $questions, array $reponsesEtudiant): array
    {
        $score = 0;
        $total = count($questions);
        $resultats = [];

        foreach ($questions as $question) {

            $qid = $question['id'];
            $selectedAnswerId = $reponsesEtudiant[$qid] ?? null;

            $isCorrect = false;
            $bonneReponse = null;
            $reponseEtudiantText = null;

            foreach ($question['answers'] as $answer) {

                if ($answer['is_correct']) {
                    $bonneReponse = $answer['text'];
                }

                if ($answer['id'] == $selectedAnswerId) {
                    $reponseEtudiantText = $answer['text'];
                    $isCorrect = $answer['is_correct'] == 1;
                }
            }

            if ($isCorrect) {
                $score++;
            }

            $resultats[] = [
                'question' => $question['question'],
                'reponse_etudiant' => $reponseEtudiantText,
                'bonne_reponse' => $bonneReponse,
                'correct' => $isCorrect
            ];
        }

        return [
            'score' => $score,
            'total' => $total,
            'resultats' => $resultats
        ];
    }
}

$reponsesEtudiant = $_POST['reponses'] ?? [];

$service = new QuizCorrectionService();
$result = $service->corriger($questions, $reponsesEtudiant);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quiz Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-10">

    <div class="bg-white p-6 rounded-xl shadow text-center mb-6">
        <h1 class="text-2xl font-bold">Résultat du Quiz</h1>

        <p class="text-lg mt-2">
            Score :
            <span class="text-blue-600 font-bold">
                <?= $result['score'] ?> / <?= $result['total'] ?>
            </span>
        </p>

        <p class="text-gray-500">
            <?= round(($result['score'] / max($result['total'],1)) * 100) ?>%
        </p>
    </div>

  
    <div class="space-y-4">

        <?php foreach ($result['resultats'] as $r): ?>

            <div class="bg-white p-5 rounded-xl shadow">

                <h2 class="font-semibold text-lg mb-3">
                    <?= $r['question'] ?>
                </h2>

                <p>
                    <span class="font-medium">Votre réponse :</span>
                    <span class="<?= $r['correct'] ? 'text-green-600' : 'text-red-600' ?>">
                        <?= $r['reponse_etudiant'] ?? 'Non répondu' ?>
                    </span>
                </p>

                <?php if (!$r['correct']): ?>
                    <p>
                        <span class="font-medium">Bonne réponse :</span>
                        <span class="text-green-600">
                            <?= $r['bonne_reponse'] ?>
                        </span>
                    </p>
                <?php endif; ?>

                <div class="mt-2">
                    <?php if ($r['correct']): ?>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            Correct ✔
                        </span>
                    <?php else: ?>
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                            Faux ✘
                        </span>
                    <?php endif; ?>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>