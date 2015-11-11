<?php
/*
* Tic Tac Toe gnieark's IA
* Version que j'aurai push si je n'avais pas eu l'occasion de tester contre l'IA
* de @Moul
* For programming challenge https://github.com/jeannedhack/programmingChallenges
* Gnieark 2015 
* licensed under the Do What the Fuck You Want to Public License http://www.wtfpl.net/
*/
function scoreCases($grid,$myChar,$hisChar){
    //lister les cases vides de la grille
	foreach($grid as $key => $case){
        $tempGrid=$grid;
        $tempGrid[$key]=$myChar;
        if($case==""){ //on ne "score que les cases qui sont libres
            //tester si je gagne en jouant là
            if(isGridWin($tempGrid)){
                $scores[$key]=1000;
                break;
            }
            if(adversaryCanWinNextTime($tempGrid,$hisChar)){
                //echo "plop";
		$scores[$key]=-999;
                break;
            }
            if(nbFreeCases($tempGrid)<2){
                $scores[$key]=0;
                break;
            }
            //allons en profondeur on va prendre la moyenne du score des coups suivants possibles
            //l'ennemi joue au meilleur endroit
            $ennemiScores=scoreCases($tempGrid,$hisChar,$myChar);
            
            $score=-10000;
            foreach($ennemiScores as $enKey => $sc){
                if($sc>$score){
                    $score=$sc;
                    $nextEnemycase=$enKey;
                }
            }
            
            $tempGrid[$enKey]=$hisChar;
            $myScores=scoreCases($tempGrid,$myChar,$hisChar);
            $count=0;
            $somme=0;
            foreach($myScores as $nb){
                $somme+=$nb;
                $count++;
            }
            $scores[$key]=($somme/$count)/2;
            
        }
    }
    if(!isset($scores)){
        echo "erreur"; die;
    }
     return $scores;
}
function nbFreeCases($grille){
	$nb=0;
    foreach($grille as $case){
        if ($case==""){
            $nb++;
        }
    }
    return $nb;
}
function adversaryCanWinNextTime($grille,$hisChar){
   
    foreach($grille as $key=> $case){
         if($case==""){
            $tempGrid=$grille;
            $tempGrid[$key]=$hisChar;
            if(isGridWin($tempGrid)){
                return true;
            }
         }
    }
    return false;
}
function isGridWin($grille){
  if(
            (($grille['0-0']==$grille['0-1'])&&($grille['0-1']==$grille['0-2'])&&($grille['0-2']!==""))
        OR  (($grille['1-0']==$grille['1-1'])&&($grille['1-1']==$grille['1-2'])&&($grille['1-2']!==""))
        OR  (($grille['2-0']==$grille['2-1'])&&($grille['2-1']==$grille['2-2'])&&($grille['2-2']!==""))
        OR  (($grille['0-0']==$grille['1-0'])&&($grille['1-0']==$grille['2-0'])&&($grille['2-0']!==""))
        OR  (($grille['0-1']==$grille['1-1'])&&($grille['1-1']==$grille['2-1'])&&($grille['2-1']!==""))
        OR  (($grille['0-2']==$grille['1-2'])&&($grille['1-2']==$grille['2-2'])&&($grille['2-2']!==""))
        OR  (($grille['0-0']==$grille['1-1'])&&($grille['1-1']==$grille['2-2'])&&($grille['2-2']!==""))
        OR  (($grille['0-2']==$grille['1-1'])&&($grille['1-1']==$grille['2-0'])&&($grille['2-0']!==""))
    ){
        return true;
    }
    return false;
    
}


$cases=array("0-0","0-1","0-2","1-0","1-1","1-2","2-0","2-1","2-2");
//filling array
$freeCases=array();
foreach($cases as $case){
	if (!isset($_GET[$case])){
		echo "wrong parameters ".$case; die;
	}
	if($_GET[$case]==""){
		$freeCases[]=$case;
	}else{
            if (!$_GET[$case]==$_GET['you']){
                $hisChar=$_GET[$case];
            }
	}
	$grille[$case]=$_GET[$case];
}
if(!isset($_GET['you'])){
	echo "wrong parameters 2"; die;
}
if (count($freeCases)==0){
	echo "error. Grid is full, beach!";
	die;
}
if (isGridWin($grille)){
    echo ("erreur, la grille a déjà été gagnée"); die;
}
if(!isset($hisChar)){
    // si le caractere ennemi n'a pas été trouvé (il n'a pas déjà joué), on le définit arbitrairement.
    if($_GET['you']=="!")
        $hisChar="?";
    else
        $hisChar="!";
}
$scoresDesCases=scoreCases($grille,htmlentities($_GET['you']),$hisChar);
$sc=-10000;
foreach($scoresDesCases as $key=>$caseValue){
    if($caseValue>$sc){
        $sc=$caseValue;
        $beastCase=$key;
    }
}

echo  $beastCase;