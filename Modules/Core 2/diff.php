<?php
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\sessionStart.php");
function generateNumber(){
	$x = 0;
	do{
		$x = mt_rand(-5,5);
	}while ($x == 0);
	$y = mt_rand(1,10);
	if ($y % 2 == 0){
		if ((2*$x == $y)){
			return "1";
		}
		if (2*$x+$y == 0){
			return "-1";
		}
		if ($y == 2){
			return  (string) $x;
		}
		return (string) $x . '/' . (string) $y / 2;
	}
	return (string) $x;
}

function generateQuestion(){
	$num = mt_rand(2,5);
	$tempString = "";
	for ($i = 0; $i < $num; $i++){
		$coeff = generateNumber();
		if ($coeff[0] != "-"){
			$coeff = "+". $coeff;
		}
		if ($coeff == '1'){
			$coeff = "+";
		}
		if ($coeff == '-1'){
			$coeff = '-';}
		$tempString = $tempString . $coeff;
		$expon = generateNumber();
		if ($expon == 1){
			$tempString .= "x";}
		else{
			$tempString = $tempString . "x^";
			$tempString = $tempString . $expon;}
		$tempString = $tempString . " ";
	}
	//if ($tempString[0] ==  '+') $tempString = substr($tempString,1);
	return ["Differentiate:<br>y = @",substr($tempString,0,sizeof($tempString)-2)];
}

function qwikMaffs($x){ // Takes a fraction as a string and returns a number
	if ($x == "+" or $x == ""){
		return 1;}
	if ($x == "-1" or $x == "-"){
		return -1;}
	return eval('return '.$x.';');}

function slowMaffs($n, $tolerance = 1.e-6) { // Undoes Qwikmaffs: https://stackoverflow.com/questions/14330713/converting-float-decimal-to-fraction
	$pve = true; if ($n < 0){$pve = false; $n = abs($n);}
    $h1=1; $h2=0;
    $k1=0; $k2=1;
    $b = 1/$n;
    do {
        $b = 1/$b;
        $a = floor($b);
        $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
        $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
        $b = $b-$a;
    } while (abs($n-$h1/$k1) > $n*$tolerance);
	if ($pve == true)
		{return "$h1/$k1";}
	return "-$h1/$k1";}

function rebub($l,$l2=[]){// reverse bubble sort function that can take a second list to move with the first
    for ($i = 0;$i < sizeof($l)-1;$i++){
        for ($j=0;$j<sizeof($l)-$i-1;$j++){
            if ($l[$j] < $l[$j+1]){
                $x = $l[$j+1];
                $l[$j+1] = $l[$j];
                $l[$j] = $x;
				if (sizeof($l2)!= 0){
					$x = $l2[$j+1];
					$l2[$j+1] = $l2[$j];
					$l2[$j] = $x;}}}}
	return [$l,$l2];}

function toFraction($x){
		$x = (float) $x;
		if ($x == 0){
			return "0";}
		elseif (floor($x) == $x){
			return (string) $x;}
		return slowMaffs($x);}

function solve($q){
	$mem = termSplit($q);
	for ($i = 0; $i < sizeof($mem[0]); $i++){
		$mem[0][$i] *= $mem[1][$i];
		$mem[1][$i] -= 1;
		//$coeffs[$i] = toFraction($coeffs[$i]);
		//$expons[$i] = toFraction($expons[$i]);
		//echo toFraction($coeffs[$i])." ".toFraction($expons[$i])."<br>";
		}
	return sortOutNonsense($mem[0],$mem[1]);}

function termSplit($s){
	$s = str_replace('^','',$s);
	$ql = explode(" ", $s);
	$coeffs = [];
	$expons = [];
	foreach ($ql as $term){
		$termsplit = explode("x",$term);
		if (sizeof($termsplit) == 1){
			array_push($termsplit,"0");}
		array_push($coeffs,qwikMaffs($termsplit[0]));
		array_push($expons,qwikMaffs($termsplit[1]));}
	return [$coeffs,$expons];
}
function sortOutNonsense($coeffs,$expons){
	$temp = rebub($expons,$coeffs);
	$expons = $temp[0];
	$coeffs = $temp[1];
	$ret = "";
	for ($i = 0; $i < sizeof($coeffs); $i++){
		$iplusplus = false;
		if ($i < sizeof($coeffs)-1){
			if ($expons[$i] == $expons[$i+1]){
				$coeffs[$i] += $coeffs[$i+1];
				$iplusplus = true;}}
		if ($coeffs[$i] > 0) $ret .= "+";
		if ($expons[$i] == 0) $ret .= toFraction($coeffs[$i]);
		else $ret .= toFraction($coeffs[$i]). "x^" . toFraction($expons[$i]);
		if ($iplusplus) $i++;
		$ret .= " ";}
	$ret = str_replace('^1','',$ret);
	$ret = str_replace('-1x','-x',$ret);
	$ret = str_replace('+1x','+x',$ret);
	if ($ret[0] ==  '+') $ret = substr($ret,1);
	return $ret;
}

function check($q,$givenA){
	$valid = ["x","^"," ","0","9","8","7","6","5","4","3","2","1","/","-","+"];
	for ($i = 0; $i < strlen($givenA); $i++){
		if (!in_array($givenA[$i],$valid)) return false;
	}
	$a = solve($q);
	$givenA = termSplit($givenA);
	echo "correct: ".$a . '<br>';
	echo "yours: " . sortOutNonsense($givenA[0],$givenA[1]) . "<br><br>";
	if (sortOutNonsense($givenA[0],$givenA[1]) == $a) return true;
	else return false;
}
?>