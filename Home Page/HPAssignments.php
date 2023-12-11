<?php setcookie("HPChoice","Assignments",time() + (86400 * 30));
require_once("HPBase.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\sessionStart.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\DBScripts.php");
?>
<head>
<style>
	tr {
		color: #01BAEF;
		background-color: #003554;
		text-align: center;
	}
	input {
		color: #01BAEF;
		background-color: #003554;
		text-align: center;
		padding:0px;
		border: 0px;
	}
</style>
</head>
<body>
	<h1> Welcome to the revision tool. </h1>
	<div class="dropdown" style = "position: absolute;top: 110px; left: 1000px;">
	  <button onclick="dropDownToggle()" class="dropbtn">Assignments
	  <img src = "downarrow.png" style = "position: absolute;top: 2px; left: 245px;,width: 20px; height: 16px;"></button>
	  <div id="myDropdown" class="dropdown-content">
		<a href="HPPassword.php">Reset Password</a>
		<a href="HPGraphs.php">Graphs</a>
		<a href="HPTopics.php">Recommended Topics</a>
	  </div>
	</div>
	<form style = "left:225px; top:150px; position:absolute;" action = "">
	<table style = "width:1050px">
		<tr>
		<td>Due date</td> <td>Due time</td> <td>Assignment Name</td><td>Assignment Topic</td>
		</tr>
		<?php
		$stoodid = getID();
		$sql = DBConnect();	
		$q = $sql->query("SELECT assignmentID FROM tblAssignmentComplete WHERE studentID = '$stoodid' AND complete = '0'");
		if ($q->num_rows > 0){
			while($row = $q->fetch_assoc()){
				$id = $row["assignmentID"];
				echo "<tr>";
				$fo = fopen("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\Assignments/$id.json","r");
				$json = json_decode(fread($fo,filesize("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\Assignments/$id.json")),true);
				fclose($fo);
				foreach (["dueDate","dueTime","name"] as $thing) echo "<td>".$json[$thing]."</td>";
				if ($json["topic"] == "other") echo "<td>Teacher Set Questions</td>";
				else{
					$topic = explode(" ",$json["topic"]);
					$json2 = json_decode(getModulejson($topic[0]),true);
					$topic[0] = $json2["name"];
					echo "<td> $topic[0] ". $json2["topics"][$topic[1]]["name"] ." </td>";
				}
				echo "<td style='background-color:#0582CA;'><input type='submit' name = '$id' value = 'Do this assignment'></td>";
				echo "</tr>";
			}
		}
		$sql->close();
		?>
	</table>
	</form>
</body>