<?php


class QuizCorrectionService
{
    public function corriger(array $questions, array $reponsesEtudiant): array
    {
        $score = 0;
        $total = count($questions);

        $resultats = [];

        foreach ($questions as $question) {

            $id = $question['id'];

            $bonneReponse = $question['bonne_reponse'];

            $reponseEtudiant = $reponsesEtudiant[$id] ?? null;

            $estCorrect = $reponseEtudiant === $bonneReponse;

            if ($estCorrect) {
                $score++;
            }

            $resultats[] = [
                'question' => $question['question'],
                'bonne_reponse' => $bonneReponse,
                'reponse_etudiant' => $reponseEtudiant,
                'correct' => $estCorrect
            ];
        }

        return [
            'score' => $score,
            'total' => $total,
            'resultats' => $resultats
        ];
    }
}