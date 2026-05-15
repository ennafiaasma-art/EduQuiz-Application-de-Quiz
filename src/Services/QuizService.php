<?php
namespace App\Services;

class QuizService{
    public function calculateScore(array $userAnswers, array $correctAnswers): int{
        $score = 0;
        foreach ($userAnswers as $qId => $aId){
            if(isset($correctAnswers[$qId]) && $correctAnswers[$qId] == $aId){
                $score++;
            }
        }
        return $score;

    }
}