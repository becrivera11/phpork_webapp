<!--
	* PROTOTYPE PORK TRACEABILITY SYSTEM
	* Copyright © 2014 UPLB.

-->
<!DOCTYPE HTML>
<html lang="en"> 
	<?php
		session_start();
		require_once "connect.php";
		if(!isset($_SESSION['username']) || !isset($_SESSION['password']))
		{
		  	header("Location: login.php");
		}
		
		
		include "inc/functions.php";
		$db = new phpork_functions ();
		
	?>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Pork Traceability System</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/style2.css">
	</head>
	<body>

		<div class="container">
			<div class="page-header">
				<img class="img-responsive" src="css/images/letterhead.png">

			</div>
			<!--<form class="form-horizonta logout" method="post" action="logout.php" style="width:30%; margin:0 0 0 70%;">
					<div class="form-group" >
						<label class="control-label col-xs-4 col-sm-4" >Current User: </label>
						<label class="control-label col-xs-2 col-sm-2 label-default" style="text-align: center; background-color: white; border: 2px solid;"><?php echo $_SESSION['username'];?></label>
						<div class="col-xs-2 col-sm-2">
							<button type="submit" class="btn btn-primary btn-sm">Logout</button>
						</div>
					</div>
				</form>-->
			<div class="row" >
				<div id="left" class="col-md-4 col-md-offset-1">
					<a href="rf11.php?location=1"><img class="img-responsive"  src="css/images/1.png"></a>
				</div>
				<div id="middle" class="col-md-4">
					<a href="rf11.php?location=2"><img class="img-responsive"  src="css/images/2.png"></a>
				</div>
				<div id="right" class="col-md-4">
					<a href="rf11.php?location=3"><img class="img-responsive"  src="css/images/3.png"></a>
				</div>
			</div>

			<div class="page-footer">
				Prototype Pork Traceability System <br> Copyright &copy; 2014 - <?php echo date("Y");?> UPLB  <br>
				funded by PCAARRD
			</div>
			
			
		</div>
	</body>
	<script type="text/javascript">
		$("document").ready(function() {
			
			
			$("#left img").on("click", function(e) {
				e.preventDefault();
				var mainloc = $('#mainLoc_id').val();
				$.ajax({
					type: "GET",
					url: "rf11.php?",
					data: "location=" + mainloc,
					success: function(data) {
						//window.open('main.php')
					}
				});
			});
		});
	</script>
</html>