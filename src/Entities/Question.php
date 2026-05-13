<?php
namespace App\Entities;

class Question{
    private int $id;
    private string $questionText;
    private arry $answers = [];

    public function __construct(int $id, string $text){
        $this->id = $id;
        $this->questionText= $text;
    }
}