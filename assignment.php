<?php

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
<h1><?php echo $json["name"];?></h1>
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
	<form action = "assignment.php" method = "post">
		<input type = "text" name = "answer" style="background-color: #0582ca; border-color: #051923; padding: none; color: #006494;font-size:25px;">
		<button class = "button" type = "submit" style="position: absolute; top:490px; left: 1050px;"> Submit </button>
	</form>
</div>
<a class = "button" href = "/edsa-h446/Home Page/HPBase.php" style="position: absolute; top:570px; left: 1175px;"><img src ="/edsa-h446/Home Page/homeicondark.png" width = 30px height = 30px style = "top: 10px; position: relative" ></a>
</body>
</html>