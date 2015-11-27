<?php
/*
	This file authenticates the admin when logging in.
*/
session_start();
require "connect.php";
$message="";
if(count($_POST)>0)
{
	$result = mysqli_query($con, "SELECT * FROM user WHERE user_name='" . $_POST["username"] . 
		"' and password = '". $_POST["password"]."'");
	$row  = mysqli_fetch_array($result);
	if(is_array($row))
	{
		$_SESSION["user_id"] = $row[user_id];
		$_SESSION["username"] = $row[user_name];
		$_SESSION["password"] = $row[password];
	}
	if(isset($_SESSION["user_id"]))
	{
		header("Location: index.php");
	}
	else
	{

		header("Location: login.php");
	}
	if(($_SESSION["username"]!= $row[user_name]) || ($_SESSION["password"] != $row[password])){
		echo "<script> alert('Invalid password/username!');</script>";
	}
	// Free result set
mysqli_free_result($result);
mysqli_close($con);
}
?>	