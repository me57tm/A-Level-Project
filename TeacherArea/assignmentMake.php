<?php
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\Home Page\HPScripts.php");
if (isset($_GET["done"])){
	$sql = DBConnect();
	$id = generateID("tblAssignments","assignmentID");
	$jsonString = "{";
	foreach(["topic","dueDate","dueTime","name"] as $thingToAdd){
		$jsonString .= '"$thingToAdd": "' . $_SESSION["$thingToAdd"] .'", ';
		unset($_SESSION["$thingToAdd"]);
	}
	$jsonString .='"questions": [';
	foreach($_SESSION["assQs"] as $qaPair){
		$jsonString .='{"question": ["' . $qaPair[0][0] . '", "' . $qaPair[0][1] . '"], ';
		$jsonString .='"answer": "' . $qaPair[1] . '"}, ';
	}
	$jsonString =  substr($jsonString,0,strlen($jsonString)-2);
	$jsonString .= "]}";
	unset($_SESSION["assQs"]);
	$fo = fopen("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\Assignments/$id.json","a");
	fwrite($fo,$jsonString);
	fclose($fo);
	$class = $_SESSION["class"];
	$q = $sql->query("INSERT INTO tblAssignments (assignmentID, classID) VALUES ('$id', '$class')");
	$q = $sql->query("SELECT studentID FROM tblStudents WHERE classID = '$class'");
	while ($student = $q->fetch_assoc()){
		$id2 = generateID("tblAssignmentComplete","ID");
		$student = $student["studentID"];
		$q2 = $sql->query("INSERT INTO tblAssignmentComplete (ID, assignmentID, studentID) VALUES ('$id2', '$id', '$student')");
	}
	$sql->close();
	echo "<script>window.location.href = '/edsa-h446/TeacherArea/teacherHome.php'</script>";
}
if (isset($_POST["sub"])){
	if ($_POST["sub"] == "Add generated question") array_push($_SESSION["assQs"],[$_SESSION["question"],"xX_GENERATETHEANSWER_Xx"]);
	else if (isset($_POST["question"]) and isset($_POST["answer"])) array_push($_SESSION["assQs"],[[$_POST["question"],"nope.avi"],$_POST["answer"]]);
}
if ($_SESSION["topic"] != "other"){
	$topic = explode(" ",$_SESSION["topic"]);
	$modulejson = json_decode(getModulejson($topic[0]),true);
	$sdir = scandir("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\Modules",0);
	$folder = $sdir[$topic[0]+2];
	require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT/Modules/$folder/".$modulejson["topics"][$topic[1]]["id"].".php");
	$_SESSION["question"] = generateQuestion();
	echo "Generated Question:<br>";
	echo str_replace("@",$_SESSION["question"][1],$_SESSION["question"][0]);
	echo '<br>
		<form action = "assignmentMake.php" method = "post">
		<input type="submit" name="sub" value="Add generated question"><br>
		Or enter a question/answer pair below<br>
		Question: <input type="text" name = "question"><br>
		Answer:   <input type="text" name = "answer"><br>
		<input type="submit" name="sub" value="Add custom question"><br>
		Or<br>
		<input type="submit" value="Generate new question">
		</form>';
}
else{
	echo '<br>
		<form action = "assignmentMake.php" method = "post">
		Enter a question/answer pair below<br>
		Question: <input type="text" name = "question"><br>
		Answer:   <input type="text" name = "answer"><br>
		<input type="submit" name="sub" value="Enter Question">
		</form>';
}
echo "<br>Current questions in assignment:";
if (isset($_SESSION["assQs"])){
	foreach($_SESSION["assQs"] as $assQ){
		echo "<br>";
		if ($assQ[0][1] == "nope.avi") echo $assQ[0][0];
	else echo str_replace("@",$assQ[0][1],$assQ[0][0]);
	}
}
else $_SESSION["assQs"] = [];
?>
<form action="assignmentMake.php" method = "get"> <input style="font-size: 20px;" type="submit" name="done" value="Create Assignment"> </form>
