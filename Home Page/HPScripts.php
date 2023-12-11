<?php
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\sessionStart.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
$dir = "C:/Users/jonat.DESKTOP-6025MRQ/Desktop/H446 PHP DEVELOPMENT/";
function tabColour($pageName,$img=false){
	if ($img) {
		if ($_SESSION["HPColour"] == $pageName) echo "/edsa-h446/Home%20Page/homeicondark.png";
		else echo "/edsa-h446/Home%20Page/homeiconlight.png";}
	else{
		if ($_SESSION["HPColour"] == $pageName){
			echo 
				"background-color: #0582CA;
				color: #003554;";}
		else{
			echo 
				"background-color: #003554;
				color: #0582CA;";}}}
function countModules(){
	return count(scandir("$GLOBALS[dir]Modules",0)) -2;}
function getModulejson($x){
	$mods = scandir("$GLOBALS[dir]Modules",0);
	$folderName = $mods[$x+2];
	$fo = fopen("$GLOBALS[dir]Modules/$folderName/info.json","r");
	$json = fread($fo,filesize("$GLOBALS[dir]Modules/$folderName/info.json"));
	fclose($fo);
	return $json;
}
function getModuleCode($x){
	$json = getModulejson($x);
	$y = json_decode($json,true);
	return $y["id"];
}	
function tabStyle(){
	$modulesInstalled = countModules();
	$modulesInstalled++;
	if ($modulesInstalled <= 5) $tabSize = 1;
	else $tabSize = (500/$modulesInstalled - 10)/90;
	for ($i=0; $i<$modulesInstalled-1;$i++){
		$position = 100 + ($tabSize*92+10)*($i+1);
		echo "#tab$i {float: left; position: absolute; left: 125px; border-radius: 10px; width: 100px; text-decoration: none;";
		echo "height:" . $tabSize * 92 ."px;";
		echo "top:" . $position. "px;";
		tabColour("$i");
		echo "}";
}
function createTabs(){
	$modulesInstalled = countModules();
	if ($modulesInstalled <= 5) $tabSize = 1;
	else $tabSize = (500/$modulesInstalled - 10)/92;
	for ($i=0; $i<$modulesInstalled;$i++){
		$moduleCode = getModuleCode($i);
		echo "<a id=tab$i href = 'HPModule.php?id=$i'>";
		echo "<p style = 'position: relative; left:10px; margin:0px; top: " . $tabSize * 25 . "px; font-size: ". $tabSize*30 . "px;'>";
		echo $moduleCode . "</p>";
		echo "</a>";}}
}
function getHPChoice(){
	if(!isset($_COOKIE["HPChoice"])){
		return "Graphs";}
	return $_COOKIE["HPChoice"];
}
function testForScores(){
	if (isset($_SESSION["question"]) and $_SESSION["qsAsked"][0] > 0){
		echo "TOTAL ".$_SESSION["qsAsked"][0]." Correct " . $_SESSION["correctAnswers"] . "<br>";
		$score = $_SESSION["correctAnswers"] / $_SESSION["qsAsked"][0];
		echo $score;
		$time = time();
		$db = DBConnect();
		$newScoreID = generateID("tblScores","scoreID");
		$studentID = getID();
		$json = json_decode(getModulejson($_SESSION["activeTopic"][0]),true);
		$moduleID = $json["id"];
		$topicID = $json["topics"][$_SESSION["activeTopic"][1]]["id"];
		$q = $db->query("INSERT INTO tblScores (scoreID,studentID,moduleID,topicID,score,time) VALUES ('$newScoreID','$studentID','$moduleID','$topicID','$score','$time')");
		$db->close();
		unset($_SESSION["question"]);
	}
}
function testForAssignments(){
	$stoodid = getID();
	$sql = DBConnect();
	$q = $sql->query("SELECT * FROM tblAssignmentComplete WHERE studentID = '$stoodid' AND complete = '0'");
	if ($q->num_rows > 0){
		echo '<a href="HPAssignments.php" style="font-size: 25px; position: absolute; top:20px; left:600px; color: #051923; text-decoration: none; background-color: #01BAEF">! You have '. $q->num_rows .' pending assignments, see homepage.</a>';
	}
	$sql->close();
}

function HPBoot(){
	testForScores();
	testForAssignments();
	if ($_SERVER["PHP_SELF"] == "/edsa-h446/Home Page/HPBase.php"){
		if (countModules() == 0) echo "<h2 style = 'color: red;'>! Warning, no modules are installed !<h2>";
		else echo "<script> window.location.href = 'HP".getHPChoice().".php' </script>";
}}
?>