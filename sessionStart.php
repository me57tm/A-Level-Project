<?php
if (session_status() == PHP_SESSION_NONE){
	session_start();
if (!isset($_SESSION["user"])){
		session_unset();
		$_SESSION["LIError"] = "You must log in to access that page.";
		echo "<script> window.location.href = '/edsa-h446/login.php' </script>";
}}
?>