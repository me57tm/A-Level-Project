<?php 
require_once("HPBase.php");
if ($_GET["id"] >= countModules()) echo "<script> window.location.href = 'HP".getHPChoice().".php' </script>";
echo "<h1>";
$json = getModuleJson($_GET["id"]);
$json = json_decode($json,true);
$_SESSION["activeTopic"] = [$_GET["id"],""];
$tabcount = count($json["topics"]);
echo $json["name"]."</h1>";
$positions = [[150,280],[150,480],[150,680],[150,880],[150,1080],[350,380],[350,580],[350,780],[350,980]];
?>
<style>
.topic{
	background-color: #003554;
	color: #01baef;
	width: 130px;
	height: 130px;
	padding: 0px;
	border: 0px;
	position: absolute;
}
</style>
<form action = "/edsa-h446/exercise.php" method = "get">
<?php 
if ($tabcount > 0){
	for ($i = 0; $i < $tabcount; $i++){
		echo '<button name="topic" type = "submit" value = "'.$i.'" class = "topic" style = "top:'.$positions[$i][0].'px;left:'.$positions[$i][1].'px;">';
		echo $json["topics"][$i]["name"];
		echo "</button>";
}}
else echo "<p style = 'top:120px;left:250px;position:absolute;'>There doesn't appear to be any topics in this module. Please contact an administrator.</p>";
?>
</form>