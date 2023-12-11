<?php require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\Home Page\HPScripts.php");

if (isset($_POST["topic"]) and isset($_POST["dueDate"]) and isset($_POST["dueTime"]) and isset($_POST["name"]) and isset($_POST["class"])){
	if (strtotime($_POST["dueDate"] . " " . $_POST["dueTime"]) < time()){
		echo "Due date must not be in the past.";
	}
	else{
		$l = ["topic","dueDate","dueTime","name","class"];
		foreach ($l as $var){
			$_SESSION[$var] = $_POST[$var];
		}
		echo "<script> window.location.href = '/edsa-h446/TeacherArea/assignmentMake.php'</script>";
	}
}
?>
<h1> Create Assignments </h1>
<form action = "assignmentForm.php" method = "post">
<?php
for ($i = 0; $i < countModules(); $i++){
	$x = json_decode(getModulejson($i),true);
	echo $x['name'] . " <br>";
	for ($j = 0; $j < count($x["topics"]); $j++){
		echo "<input type='radio' name = 'topic' value = '";
		echo $i . " " . $j . "'>";
		echo $x["topics"][$j]["name"];
		echo "</input><br>";
	}
}
?>
<input type = "radio" name = "topic" value = "other"> Other </input>
<br>
<input type="date" name="dueDate"value = "<?php echo date("Y-m-d")?>">
<input type = "time" name = "dueTime" value = "00:00"> <br>
<input type = "text" name = "name" value = "Assignment Name"> <br>
Class <br>
<?php
$sql = DBConnect();
$id = getID(false,"teacher");
$q = $sql->query("SELECT * FROM tblClasses WHERE teacherID = '".$id."'");
while($class = $q->fetch_assoc()){
	echo '<input type="radio" name = "class" value = "';
	echo $class["classID"] . '">';
	echo $class["className"];
	echo "</input>";
	echo "<br>";
}
$sql->close();
?>
<input type = "submit">
</form>
<a href = "teacherHome.php"> Home <a>