<?php
$dir = "C:/Users/jonat.DESKTOP-6025MRQ/Desktop/H446 PHP DEVELOPMENT";
require_once("$dir\Home Page\HPScripts.php");
if (isset($_GET["topic"])){
	$_SESSION["activeTopic"][1] = $_GET["topic"];
	echo "<script> window.location.href = 'exercise.php' </script>";
}
function displayMaths($x){
	$brak = 0;
    for ($i = 0; $i < strlen($x); $i++){
        if ($x[$i] == "("){
            $brak += 1;
		}
        if (($x[$i] == " ") and ($brak == 0)){
            $x = displayMaths(substr($x,0,$i)) ." ". displayMaths(substr($x,$i+1));
		}
        if ($x[$i] == ")"){
            $brak -= 1;
		}
	}
    if (strpos($x,"^") !== False){
        $x = str_replace("^","<sup>",$x);
        $x = $x . "</sup>";
	}
    return $x;
}
$json = json_decode(getModuleJson($_SESSION["activeTopic"][0]),true);
$oof2 = $json["topics"][$_SESSION["activeTopic"][1]]["id"];
$oof1 = scandir("$dir/Modules",0)[$_SESSION["activeTopic"][0]+2];
#$oof1 = "Core 2";
require_once("$dir/Modules/$oof1/$oof2.php");
?>
<html>
<head>
<style>
	body {
		background-color: #006494;
		font-family: Arial;}
	h1 {
		position: absolute;
		top: 0px;
		background-color: #003554;
		float: left;
		color: #0582CA; 
		width: 1325px;
		padding: 10px;
		border: 5px;
		font-size: 1.75em;
		font-weight: normal;
		text-align: left;}
	#mainArea{
		text-align:center;
		color: #006494;
		font-size: 50px;
		position: absolute;
		top: 80px;
		background-color: #0582CA;
		width: 1345px;
		height: 550px;
		float: left;
		
	}
	.button{
		background-color: #01BAEF;
		width: 100px;
		text-align: center;
		height: 50px;
		color: #003554;
		font-size: 20px;
		border: none;
	}
		
</style>
</head>
<body>
<h1><?php echo $json["name"] . " - ". $json["topics"][$_SESSION["activeTopic"][1]]["name"];?></h1>
<div id = "mainArea">
	<br>
	<?php
	if (isset($_SESSION["question"])){
		$_SESSION["qsAsked"][0] += 1;
		array_push($_SESSION["qsAsked"][1],$_SESSION["question"]);
		if (isset($_POST["answer"])){
			if (check($_SESSION["question"][1],$_POST["answer"])){
				echo "correct";
				$_SESSION["correctAnswers"] += 1;
			}
		}
	}
	else {
		$_SESSION["qsAsked"] = [-1,[]]; 
		$_SESSION["correctAnswers"] = 0;
	}
	$_SESSION["question"] = generateQuestion();
	$out = str_replace("@",displayMaths($_SESSION["question"][1]),$_SESSION["question"][0]);
	echo $out;
	?>
	<br>
	<form action = "exercise.php" method = "post">
		<input type = "text" name = "answer" style="background-color: #0582ca; border-color: #051923; padding: none; color: #006494;font-size:25px;">
		<button class = "button" type = "submit" style="position: absolute; top:490px; left: 1050px;"> Submit </button>
	</form>
</div>
<a class = "button" href = "/edsa-h446/Home Page/HPBase.php" style="position: absolute; top:570px; left: 1175px;"><img src ="/edsa-h446/Home Page/homeicondark.png" width = 30px height = 30px style = "top: 10px; position: relative" ></a>
</body>
</html>
