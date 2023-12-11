<!DOCTYPE HTML>
<html lang = "en-GB">
<?php require_once("HPScripts.php");
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\sessionStart.php");
if ($_SERVER["PHP_SELF"] == "/edsa-h446/Home Page/HPModule.php") $_SESSION["HPColour"] = $_GET["id"];
else $_SESSION["HPColour"] = "home";
HPBoot();
$modulesInstalled = countModules();
$modulesInstalled++;
if ($modulesInstalled <= 5) $tabSize = 1;
else $tabSize = (500/$modulesInstalled - 10)/92; ?>
<head>
	<title> Home </title>
	<style>
		body {
			font-family: Arial, "Sans-serif";
			background-color: #006494;}
		h1 {
			position: absolute;
			top: 0px;
			background-color: #003554;
			float: left;
			color: #0582CA; 
			width: 400px;
			padding: 10px;
			border: 5px;
			font-size: 1.75em;
			font-weight: normal;
			text-align: left;}
		#mainArea{
			float: left;
			position: absolute;
			background-color: #0582CA;
			left:200px;
			top:100px;
			height:500px;
			width: 1100px;}
		#homeTab{
			float: left;
			position: absolute;
			top: 100px;
			left: 125px;
			border-radius: 10px;
			height:<?php echo $tabSize*92?>px;
			width: 100px;
			<?php tabColour("home")?>
			}
		<?php tabstyle();?>
		.dropbtn {
			background-color: #051923; color: #01BAEF;
			width: 275px;
			text-align: left;
			font-size: 16px;
			border: none;
			cursor: pointer;}
		.dropbtn:hover, .dropbtn:focus {
			background-color: #01BAEF;
			color:#051923;}

		.dropdown {
			position: relative;
			display: inline-block;}
		.dropdown-content {
			width: 275px;
			display: none;
			position: absolute;
			background-color: #051923;
			z-index: 1;
		}


		.dropdown-content a {
			color: #01BAEF;
			text-decoration: none;
			display: block;
		}
		.dropdown-content a:hover {background-color: #003554}
		.show {display:block;}
	</style>
	<script>
		function dropDownToggle() {
			document.getElementById("myDropdown").classList.toggle("show");
		}
		window.onclick = function(event) {
		  if (!event.target.matches('.dropbtn')) {

			var dropdowns = document.getElementsByClassName("dropdown-content");
			var i;
			for (i = 0; i < dropdowns.length; i++) {
			  var openDropdown = dropdowns[i];
			  if (openDropdown.classList.contains('show')) {
				openDropdown.classList.remove('show');
			  }
			}
		  }
		}
	</script>
</head>
<body>
<!--<h1><?php// echo $_SERVER["PHP_SELF"] ?></h1>-->
<br>
<a id= "homeTab" href="/edsa-h446/Home%20Page/HPBase.php">
	<img src=<?php tabColour("home",true)?> style="width:<?php echo $tabSize*50?>px; height:<?php echo $tabSize*50?>px; position: relative; left:15px; top: <?php echo $tabSize*20?>px;">
</a>
<?php createTabs();?>
<div id= "mainArea"></div>
</body>
</html>