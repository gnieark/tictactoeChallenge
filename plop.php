<?php
/*
* Tic Tac Toe gnieark's IA
* For programming challenge https://github.com/jeannedhack/programmingChallenges
* Gnieark 2015 
* licensed under the Do What the Fuck You Want to Public License http://www.wtfpl.net/
*/
function scoreCases($grid,$myChar,$hisChar,$depth=0){
	//list empty cells
	foreach($grid as $key => $cell){
        $tempGrid=$grid;
        $tempGrid[$key]=$myChar;
        if($cell==""){ 
            //do i win if i play there?
            if(isGridWin($tempGrid)){
		if(fmod($depth,2)==0){
		 $scores[$key]=10-$depth;	
           	}else{
		 $scores[$key]=$depth-10;
		}	
	    }elseif(nbFreeCases($tempGrid)==0){
		$scores[$key]=0;
	    }else{
		//find the beast score
		$scores[$key]=0;
		$scoresDeeper=scoreCases($tempGrid,$hisChar,$myChar,$depth+1);
		foreach($scoresDeeper as $scD){
			if(abs($scD)>abs($scores[$key])){
			 $scores[$key]=$scD;
			}
		}
	    }
	}
	}
     return $scores;
}
function nbFreeCases($map){
	$nb=0;
    foreach($map as $cell){
        if ($cell==""){
            $nb++;
        }
    }
    return $nb;
}
function isGridWin($map){
  if(
            (($map['0-0']==$map['0-1'])&&($map['0-1']==$map['0-2'])&&($map['0-2']!==""))
        OR  (($map['1-0']==$map['1-1'])&&($map['1-1']==$map['1-2'])&&($map['1-2']!==""))
        OR  (($map['2-0']==$map['2-1'])&&($map['2-1']==$map['2-2'])&&($map['2-2']!==""))
        OR  (($map['0-0']==$map['1-0'])&&($map['1-0']==$map['2-0'])&&($map['2-0']!==""))
        OR  (($map['0-1']==$map['1-1'])&&($map['1-1']==$map['2-1'])&&($map['2-1']!==""))
        OR  (($map['0-2']==$map['1-2'])&&($map['1-2']==$map['2-2'])&&($map['2-2']!==""))
        OR  (($map['0-0']==$map['1-1'])&&($map['1-1']==$map['2-2'])&&($map['2-2']!==""))
        OR  (($map['0-2']==$map['1-1'])&&($map['1-1']==$map['2-0'])&&($map['2-0']!==""))
    ){
        return true;
    }
    return false;
    
}
$cells=array("0-0","0-1","0-2","1-0","1-1","1-2","2-0","2-1","2-2");
//filling array
$emptyCells=array();
foreach($cells as $cell){
	if (!isset($_GET[$cell])){
		echo "wrong parameters ".$cell; die;
	}
	if($_GET[$cell]==""){
		$emptyCells[]=$cell;
	}else{
            if ($_GET[$cell]!==$_GET['you']){
                $hisChar=$_GET[$cell];
            }
	}
	$map[$cell]=$_GET[$cell];
}
if(!isset($_GET['you'])){
	echo "wrong parameters 2"; die;
}
if (count($emptyCells)==0){
	echo "error. Grid is full, beach!";
	die;
}
if (isGridWin($map)){
    echo ("erreur, i have  allready win this tictactoe"); die;
}
if(!isset($hisChar)){
    // if opponent char does not exist. (first move) choose one for him.
    if($_GET['you']=="!"){
        $hisChar="?";
   }else{
        $hisChar="!";
   }
}
$scoresDesCases=scoreCases($map,htmlentities($_GET['you']),$hisChar);
$sc=-10000;
foreach($scoresDesCases as $key=>$cellValue){
	if($cellValue>$sc){
        $sc=$cellValue;
        $beastCase=$key;
    }
}
echo $beastCase;