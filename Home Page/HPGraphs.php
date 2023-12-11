<?php setcookie("HPChoice","Graphs",time() + (86400 * 30));
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\drawGraph.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
require_once("HPBase.php");
$sql = DBConnect();
$id = getID();
//if (!isset($_POST["memes"])){echo 'l';}
if ((!isset($_SESSION["graphTopic"])) or ($_SESSION["graphTopic"] == "All")){
	$q = $sql->query("SELECT score, time FROM tblScores WHERE studentID = '$id'");//CHECK IF THIS LINE IS SAFE
	//$q = $q->fetch_assoc();
}
$data = [];
if ($q->num_rows == 0)$_SESSION["graphData"] = null;
while ($res = $q->fetch_assoc()){
	array_push($data,[$res["score"],$res["time"]]);
}
$ret = "";
$i = 0;
foreach($data as $row){
	$ret .= "[$i,$row[0]],";
	$i++;
}
$_SESSION["graphData"] =  $ret;
?>
<head>
</head>
<body>
	<div id="chart_div" style = "position: absolute; top: 150px; left: 300px;"></div>
	<h1> Welcome to the revision tool. </h1>
	<div class="dropdown" style = "position: absolute;top: 110px; left: 1000px;">
		<button onclick="dropDownToggle()" class="dropbtn">Graphs<img src = "downarrow.png" style = "position: absolute;top: 2px; left: 245px;,width: 20px; height: 16px;"></button>
		<div id="myDropdown" class="dropdown-content">
			<a href="HPTopics.php">Recommended Topics</a>
			<a href="HPAssignments.php">Assignments</a>
			<a href="HPPassword.php">Reset Password</a>
	    </div>
	</div>
	<form action="HPGraphs.php" method = "post">
		
	</form>
</body>