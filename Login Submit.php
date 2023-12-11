<?php
session_start();
require_once("DBscripts.php");

function goBack($error){
	if (!isset($_SESSION["LIAttempts"])) $_SESSION["LIAttempts"] = 1;
	else $_SESSION["LIAttempts"] += 1;
	$_SESSION["LIError"] = $error;
	echo "<script> window.location.href = 'login.php' </script>";
}
if (empty($_POST["username"]) or empty($_POST["password"])) goBack("Both username and password fields are required.");
else{
$sql = DBConnect();
$things = DBClean([$_POST["username"],$_POST["password"]]);
$q = $sql->query("SELECT * FROM tblUsers WHERE username = '$things[0]'");
$q = $q->fetch_assoc();
if (count($q) == 0) goBack("Username or password incorrect.");
else{
if (hash("sha512",$q["salt"] . $_POST["password"]) == $q["password"]){
	session_unset();
	$mem = $q["userID"];
	if ($q["studentTeacher"] == "student"){
		$ts = "students";
		$href = 'Home Page/HPBase.php';
	}
	else {
		$ts = "teachers";
		$href = 'TeacherArea/teacherHome.php';
	}
	$q2 = $sql->query("SELECT firstname FROM tbl$ts WHERE userID = '$mem'");
	$q2 = $q2->fetch_assoc();
	$_SESSION["user"] = $q2["firstname"]." ". $q["username"];
	$sql->close();
	echo "<script> window.location.href = '$href' </script>";}	
else goBack("Username or password incorrect.");}

$sql->close();}
?>