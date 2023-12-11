<?php session_start()?>
<!DOCTYPE html>
<html lang = "en-GB">
<head>
	<style>
		body {color:#051923;}
		body {background-color: #01baef;}
		body {font-family: Arial;}
		#meme {text-align: center;}
	</style>
</head>
<body>
	<h1> Mathematics Revision Tool. </h1>
	<div id="meme">
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<h3> Please log in to continue. </h3>
		<form action = "Login Submit.php" method="post">
			<table align="center" style="font-color:#051923;">
			<tr>
				<td>Username:</td>
				<td><input type = "text" name = "username" style="background-color: #0582ca; border: none; padding: 0;"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type = "password" name = "password" style="background-color: #0582ca; border: none; padding: 0;"></td>
			</tr>
			<tr>
				<td></td>
				<td><input value = "Log In" type = "submit" style="color:#051923; font-size: 14px; background-color: #006494; border: none; padding: 20;"></td>
			</tr>
			<tr>
				<td></td><td><a href="register.php" style="color:#051923; text-decoration: none; font-size: 14px; background-color: #006494; border: none; padding: 20;">Register</a></td>
			</tr>
			</table>
		</form>
		<?php if (isset($_SESSION["LIError"])) echo "<br>".$_SESSION["LIError"]?>
	</div>
</body>
</html>