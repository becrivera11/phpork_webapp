<!DOCTYPE HTML>
<html lang = "en">
<?php
	session_start();
	if(isset($_SESSION['username']) && isset($_SESSION['password']))
	{
		header("Location: index.php");
	}
?>
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pork Traceability System</title>

	<!--[if !IE]><!-->
		<!-- <link rel="stylesheet" href="css/login.css" /> -->
	<!-- BootStrap -->
		<link rel="stylesheet" href="assets/css/bootstrap.css">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/bootstrap-theme.css">
		<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery-2.1.4.js" type="text/javascript"></script>
		<script src="js/jquery-latest.js" type="text/javascript"></script>
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="assets/js/bootstrap.js" type="text/javascript"></script>
		<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- BootStrap -->
	<!--<![endif]-->

	<!--[if gte IE 7]>
		<link rel="stylesheet" type="text/css" href="/css/main.css" media="screen, projection" />
	<![endif]-->

	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="http://universal-ie6-css.googlecode.com/files/ie6.0.3.css" media="screen, projection" />
	<![endif]-->
</head>
<body>
<div class="container">
	<div class = "page-header">
		<img class = "img-responsive"src="css/images/ss.png" alt = "letterhead" >
	</div>
	<div class="jumbotron">
    	<h2 style = "text-align: center;">Pig Display Information System<br><small> Please Log In</small> </h2>  

    	<form class = "form-horizontal log_in" style="align:center" method = "post" action = "auth.php" autocomplete = "off">
			<div class="form-group user_name">
				<label class="control-label col-sm-4" for="pwd">Username:</label>
				<div class="col-sm-6">          
					<input type="text" class="form-control" id="user" placeholder="Enter username" name = "username" required = "required">
				</div>
			</div>
			<div class="form-group password">
				<label class="control-label col-sm-4" for="pwd">Password:</label>
				<div class="col-sm-6">          
					<input type="password" class="form-control" id="pwd" placeholder="Enter password" name = "password" required = "required">
				</div>
			</div>
			<div class="form-group">        
				<div class="col-sm-offset-4 col-sm-10">
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</div>
    	</form>
  	</div>
  	<div class = "page-footer">
		&copy; 2014 - <?php echo date("Y");?> National Pork Traceability System <br> funded by PCAARRD
  	</div>
</div>
</body>
</html>