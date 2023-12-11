<?php setcookie("HPChoice","Topics",time() + (86400 * 30));
require_once("HPBase.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
?>
<head>
</head>
<body>
	<h1> Welcome to the revision tool. </h1>
	<div class="dropdown" style = "position: absolute;top: 110px; left: 1000px;">
	  <button onclick="dropDownToggle()" class="dropbtn">Recommended Topics<img src = "downarrow.png" style = "position: absolute;top: 2px; left: 245px;,width: 20px; height: 16px;"></button>
	  <div id="myDropdown" class="dropdown-content">
		<a href="HPAssignments.php">Assignments</a>
		<a href="HPPassword.php">Reset Password</a>
		<a href="HPGraphs.php">Graphs</a>
	  </div>
	</div>
</body>