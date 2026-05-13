<?php    
class Score{
    private $score;
    private  $sommepoint;
    private $nmbquestion;


    public function __construct(int $score,int $sommepoint,int $nmbquestion){


$this-> score =$score;
$this ->sommepoint=$sommepoint;
$this->nmbquestion=$nmbquestion;
    
    }

public function calculScore(){
    return 

$this->score=$this->sommepoint/$this->nmbquestion *100 ;
}



}



?>