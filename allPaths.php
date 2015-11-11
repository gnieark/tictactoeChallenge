<?php

$cases=array("0-0","0-1","0-2","1-0","1-1","1-2","2-0","2-1","2-2");
$grille=array(0,0,0,0,0,0,0,0,0); //0 nonjoué ; 1 joué par player 1; 2 idem player 2


play($grille,1,1);
play($grille,1,2);
function play($grid,$joueur,$statForPlayer,$profondeur=1){
    //trouver toutes les cases libres

    $count=0;
    $sommeScores=0;
    foreach($grid as $key => $case){
        if($case==0){
            //on joue là
            $gridTemp=$grid;
            $gridTemp[$key]=$joueur;
            //echo $key." ".$profondeur;
            //si c'est gagnant
            if(isWinGrid($grid)){
              $score=1;  
            }
            //si la grille est pleine
            elseif(isGridFull($gridTemp)){
                $score=0;
            }else{
            //sinon, on part en profondeur, next player                
                $score= - play($gridTemp,2,$statForPlayer,$profondeur+1)/$profondeur;
            }
         if($joueur==$statForPlayer){
            echo implode(",",$grid)." ".$key.":".$score." \n";
         }
         $count++;
         $sommeScores=$sommeScores+$score;
        }
    }
    
    return ($sommeScores/$count);

}
function isGridFull($grille){
    foreach($grille as $case){
        if ($case==0){
            return false;
        }
    }
    return true;
}
function isWinGrid($grille){
    $linesAndDiags=array(
                    array(0,1,2),
                    array(3,4,5),
                    array(6,7,8),
                    array(0,3,6),
                    array(1,4,7),
                    array(2,5,8),
                    array(0,4,8),
                    array(2,4,6)
                    );                
   foreach($linesAndDiags as $winComb){
    if(
        ($grille[$winComb[0]]>0)
        && ($grille[$winComb[0]]==$grille[$winComb[1]])
        && ($grille[$winComb[0]]==$grille[$winComb[2]])
    ){return true;}
   }
   return false;
}