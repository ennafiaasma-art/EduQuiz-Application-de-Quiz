<?php    
require_once "./config/Database.php";
class Score {

    private int $sommepoint;
    private int $nmbquestion;

    public function __construct(int $sommepoint, int $nmbquestion){

        $this->sommepoint = $sommepoint;
        $this->nmbquestion = $nmbquestion;
    }

    public function calculScore(){

        return ($this->sommepoint / $this->nmbquestion) * 100;
    }
}

$score = new Score(8, 10);

echo "Le score est : " . $score->calculScore() . "%";

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>