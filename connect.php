
<?php 
	$db_host = "localhost"; 
	$user = "root"; 
	$pass = ""; 
	$db_name = "phpork"; 
	$con = mysqli_connect($db_host, $user, $pass) or die ("Unable to Connect."); 
	mysqli_select_db($con, $db_name) or die( "Unable to select database.");
?>