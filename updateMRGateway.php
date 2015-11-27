<?php

	session_start();
		require_once "connect.php";
		if(!isset($_SESSION['username']) || !isset($_SESSION['password']))
		{
		  	header("Location: login.php");
		}
		
	include "inc/functions.php";
	include "inc/pigdet.php";
	$pig = new pigdet_functions();
	$db = new phpork_functions();


	echo json_encode($db->updateMeds($_GET['medid'],$_GET['mrid'],$_SESSION['user_id'])); // change '1' to $_SESSION['userid']

?>