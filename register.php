<?php session_start();require_once("DBscripts.php");?>
<!DOCTYPE html>
<html lang = "en-GB">
<head>
	<style>
		h1 {color:#051923;}
		h3 {color:#051923;}
		body {background-color: #01baef;}
		body {font-family: Arial;}
		#meme {text-align: center;}
		input {background-color: #0582ca; border: none; padding: 0;}
	</style>
</head>
<body>
	<h1> Mathematics Revision Tool. </h1>
	<div id="meme">
		<br>
		<br>
		<h3> Register here. </h3>
		<form action = "register.php" method="post">
			<table align="center">
			<tr>
				<td>Username:</td>
				<td><input type = "text" name = "username"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type = "password" name = "password"></td>
			</tr>
			<tr>
				<td>Confirm Password:</td>
				<td><input type = "password" name = "confirmPassword"></td>
			</tr>
			<tr><td>First Name:</td><td><input type="text" name = "firstName"></td></tr>
			<tr><td>Surname:</td><td><input type="text" name = "surname"></td></tr>
			<tr><td>I'm a:</td><td><input type = "radio" name="teacher/student" value="student">Student</td></tr>
			<tr><td></td><td><input type = "radio" name="teacher/student" value="teacher">Teacher</td></tr>
			<tr><td>Class Code:</td><td><input type="text" name = "code"></td></tr>
			<tr><td></td><td><input value = "Register" type = "submit" name="done" style="font-size: 14px; background-color: #006494; border: none; padding: 20;"></td></tr>
			</table>
		</form>
	</div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$_SESSION["isset"] = true;
	foreach(["username","password","confirmPassword","firstName","surname","teacher/student"] as $thing){
		if (!isset($_POST[$thing]) or empty($_POST[$thing])){
			echo $thing . " is required<br>";
			$_SESSION["isset"] = false;
		}
	}	
	if ($_SESSION["isset"]){
		if ($_POST["password"] != $_POST["confirmPassword"]){
			echo "Your 2 passwords do not match.<br>";
			$_SESSION["isset"] = false;
		}
		if ($_POST["teacher/student"] == "student" and empty($_POST["code"])){
			echo "Students must enter a class code<br>";
			$_SESSION["isset"] = false;
		}
		if (strpos($_POST["username"]," ")!==false){
			$_SESSION["isset"] = false;
			echo "User name must not contain space<br>";
		}
		if (strpos($_POST["firstName"]," ")!==false){
			$_SESSION["isset"] = false;
			echo "First name must not contain space<br>";
		}
	}
	if ($_SESSION["isset"]){
		$sql = DBConnect();
		$salt = bin2hex(openssl_random_pseudo_bytes(15));
		$pwd = hash("sha512",$salt . $_POST["password"]);
		$cleanList = DBClean([$_POST["username"],$_POST["firstName"],$_POST["surname"],$_POST["code"]]);
		$q = $sql->query("SELECT * FROM tblUsers where username = '". $cleanList[0] ."'");
		if ($q->num_rows > 0) echo "That username is already in use, try another one.";
		else{
		$userID = generateID("tblUsers","userID");
		$q = $sql->query("INSERT INTO tblUsers (userID,username,salt,password,studentTeacher) VALUES ('$userID','$cleanList[0]','$salt','$pwd','".$_POST["teacher/student"]."')");
		if ($_POST["teacher/student"] == "student"){
			$q = $sql->query("SELECT classID FROM tblClasses WHERE classCode = '". $cleanList[3] ."'")or die($sql->error);
			if ($q->num_rows == 0){
				echo "Invalid class code";
			}
			else{
				$class = $q->fetch_assoc()["classID"];
				$studentID = generateID("tblStudents","studentID");
				$q = $sql->query("INSERT INTO tblStudents (studentID,firstname,surname,classID,userID) VALUES ('$studentID','$cleanList[1]','$cleanList[2]','$class','$userID')");
				echo "<script> window.location.href = 'Home Page/HPBase.php' </script>";
			}
		}
		else{
			$teacherID = generateID("tblTeachers","teacherID");
			$q = $sql->query("INSERT INTO tblteachers (teacherID,firstname,surname,userID) VALUES ('$teacherID','$cleanList[1]','$cleanList[2]','$userID')");
			echo "<script> window.location.href = 'teacherArea/teacherHome.php' </script>";
		}}
	}
}
?>