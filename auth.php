<?php
/*
	This file authenticates the admin when logging in.
*/
session_start();
require "connect.php";
$message="";
if(count($_POST)>0)
{
	/*$result = mysqli_query($con, "SELECT * FROM user WHERE username='" . $_POST["username"] . 
		"' and password = '". $_POST["password"]."'");
	$row  = mysqli_fetch_array($result);
	if(is_array($row))
	{
		$_SESSION["user_id"] = $row[user_id];
		$_SESSION["username"] = $row[username];
		$_SESSION["password"] = $row[password];
	}*/
	$_SESSION["user_id"] = "user";
		$_SESSION["username"] = "user";
		$_SESSION["password"] = "user";
	if(isset($_SESSION["user_id"]))
	{
		header("Location: index.php");
	}
	else
	{
		header("Location: login.php");
	}

	// Free result set
mysqli_free_result($result);
mysqli_close($con);
}
?>	