<?php
require_once("HPBase.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
?>
<head>
</head>
<body>
	<h1> Welcome to the revision tool. </h1>
	<div class="dropdown" style = "position: absolute;top: 110px; left: 1000px;">
	  <button onclick="dropDownToggle()" class="dropbtn">Reset Password<img src = "downarrow.png" style = "position: absolute;top: 2px; left: 245px;,width: 20px; height: 16px;"></button>
	  <div id="myDropdown" class="dropdown-content">
		<a href="HPGraphs.php">Graphs</a>
		<a href="HPTopics.php">Recommended Topics</a>
		<a href="HPAssignments.php">Assignments</a>
	  </div>
	</div>
	<form action = "HPPassword.php" method = "post" style = "position: absolute; top: 250px; left: 500px; color: #051923;">
		<table>
			<tr>
				<td>Old password:</td>
				<td><input type = "password" name = "old" style="background-color: #051923; color: #0582ca; border: none; padding: 0;"></td>
			</tr>
			<tr>
				<td>New password:</td>
				<td><input type = "password" name = "new" style="background-color: #051923; color: #0582ca; border: none; padding: 0;"></td>
			</tr>
			<tr>
				<td>Confirm password:</td>
				<td><input type = "password" name = "confirmNew" style="background-color: #051923; color: #0582ca; border: none; padding: 0;"></td>
			</tr>
			<tr>
				<td></td>
				<td><input value = "Reset Password" type = "submit" style="background-color: #006494; border: none; padding: 20;"></td>
			</tr>
		</table>
	</form>
	<div style = "left:200px; top:100px; position: absolute;">
<?php
if (empty($_POST["old"]) or empty($_POST["new"]) or empty($_POST["confirmNew"]))echo "flelf";
else{
	if ($_POST["new"] != $_POST["confirmNew"]) echo "blelb";
	else{
		$sql = DBConnect();
		$id = getID();
		$q = $sql->query("SELECT salt,password FROM tblUsers WHERE userID = '$id'");
		$q = $q->fetch_assoc();
		if (hash("sha512",$q["salt"] . $_POST["old"]) == $q["password"]){
			$cleanPwd = DBClean($_POST["new"]);
			$sql->query("UPDATE tblUsers SET WHERE userID = '$id'");
		}
		else {echo "meem";}
}}
?></div>
</body>