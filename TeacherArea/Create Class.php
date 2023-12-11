<form action = "Create Class.php" method = "post">
Input Class Name: <input type="text" name="className"> <br>
<input value = "Create Class" type = "submit">
</form>
<a href = "teacherHome.php"> Home <a>
<?php
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
if (empty($_POST["className"])){
echo "Please enter a class name."; //Check to see if the required input has been done properly
}
else{
	$sql = dbConnect();		
	$className = mysqli_real_escape_string($sql,$_POST["className"]);
	$teacherID = getID(false,"teacher");
	$id = generateID("tblClasses","classID");
	$code = generateID("tblClasses","classCode");
	$q = $sql->query("INSERT INTO tblClasses (classID,teacherID,className,classCode) VALUES ('$id','$teacherID','$className','$code')");
	$sql->close();
	echo "<script>window.location.href = '/edsa-h446/TeacherArea/teacherHome.php'</script>";
	}
}
?>



<!-- INSERT INTO `tblclasses`(`teacherID`, `className`) VALUES (<teacher>, 'clasName') -->