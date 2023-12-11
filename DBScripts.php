<?php
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\sessionStart.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\averyimportantfolder\gabeN.php");
function DBConnect(){ // Returns a database connection
	$sql = new mysqli($GLOBALS["svr"],$GLOBALS["use"],$GLOBALS["passTheWhiskey"],$GLOBALS["datdotdat"]);
	if ($sql->connect_error){
		session_unset();
		$_SESSION["LIError"] = ("Couldn't connect to database: " . $sql->connect_error);
		echo "<script> window.location.href = '/edsa-h446/login.php' </script>";
	}
	return $sql;
}
function DBClean($ar){
	$conn = DBConnect();
	for ($i=0;$i<count($ar);$i++){
		$ar[$i] = mysqli_real_escape_string($conn,$ar[$i]);
	}
	$conn->close();
	return $ar;
}
function testResults($q){
	if (count($q) == 0){
		session_unset();
		$_SESSION["LIError"] = "There was an error accessing the database.";
		echo "<script> window.location.href = '/edsa-h446/login.php' </script>";
	}
	elseif(count($q) == 1) return true;
	else return false;
}
function getID($userID = false, $student = "student"){
	$sql = DBConnect();
	$use = explode(" ",$_SESSION["user"]);
	$use = DBClean($use);
	$q = $sql->query("SELECT $student"."ID , userID FROM tbl$student"."s WHERE firstname = '$use[0]'");//CHECK IF THIS LINE IS SAFE
	$q = $q->fetch_assoc();
	if (testResults($q)){
		if (!$userID) return $q["$student"."ID"];
		else return $q["userID"];
	}
	else{
		$q1 = $sql->query("SELECT userID FROM tblUsers WHERE username = '$use[1]'") or die($sql->error);//CHECK IF THIS LINE IS SAFE
		$q1 = $q1->fetch_assoc();
		if ($userID) return $q1["userID"];
		else{
			$temp = $q1["userID"];
			$q2 = $sql->query("SELECT $student"."ID FROM tbl$student"."s WHERE userID = '$temp'");//CHECK IF THIS LINE IS SAFE
			$q2 = $q2->fetch_assoc();
			return $q2["$student"."ID"];
		}
	}
	$sql->close();
}
function generateID($tableName,$idName){#takes the table name and id name as strings and then generates a unique random ID for a new entry.
	$dave = DBConnect();
	$q = $dave->query("SELECT * FROM $tableName");
	$numRows = $q->num_rows;
	if ($numRows < 50) $numRows = 100;
	$oldIDs = [];
	while ($result = $q->fetch_assoc()) array_push($oldIDs,$result["$idName"]);
	do {
		$id = rand(-$numRows,$numRows);
	}while (in_array($id,$oldIDs) and ($id != 0));
	$dave->close();
	return $id;
}
?>