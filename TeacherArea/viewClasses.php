<?php
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\sessionStart.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
$sql = DBConnect();
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["class"])) $_SESSION["class"] = $_POST["class"];
if (isset($_SESSION["class"]));
echo "<form>";
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
echo '<input type="submit" action="viewClasses.php" method = "post" value="View Class"> </form>';
?>
<a href = "Create Class.php">Create a new class</a><br>
<a href = "teacherHome.php"> Home </a>