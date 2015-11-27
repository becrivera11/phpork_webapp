<!--
	* PROTOTYPE PORK TRACEABILITY SYSTEM
	* Copyright © 2014 UPLB.

-->
<!DOCTYPE HTML>
<html lang="en"> 
	<?php
		require_once "connect.php";
		
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
			<div class="row">
				<div class="content" >
					<ul class="step-indicator">
						<li class="each-step active">Select house</li>
						<li class="each-step">Select pen</li>
						<li class="each-step">Select pig</li>
					</ul>
				</div>
				<div class="step-content active">
					<?php 
						$l = $_GET['location'];
						echo "<input type = 'hidden' value= '$l' name = 'loc' id = 'locid'/>";
					?>
					<span class="custom-dropdown">

						<select id="dropdown">
							<?php $db->ddl_house($_GET['location']); ?>
						</select>
					</span>
					<div id="button-holder" class="text-center col-md-10">
						<div id="prompt" style="display:none;"></div>
						<button class="btn-cust btn-cust-lg btn-cust-img-left previous " id="previous" onmouseover="popup('prev')" onmouseout="hide()">
							<span class="stepBtn">Previous</span>
						</button>
						<button class="btn-cust btn-cust-lg btn-cust-img-right next " id="next" onmouseover="popup('next')" onmouseout="hide()">
							<span class="stepBtn">Next</span>
							
						</button>
					</div>
				</div>
			</div>
			

			<div class="page-footer">
				Prototype Pork Traceability System <br> Copyright &copy; 2014 - <?php echo date("Y");?> UPLB  <br>
				funded by PCAARRD
			</div>
			
			
		</div>
		<script src="js/jquery-2.1.4.js" type="text/javascript"></script>
		<script src="js/jquery-latest.js" type="text/javascript"></script>
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery.js"></script>
		<script src="js/javascript.js"></script>
		<script src="js/jquery.min-1.js"></script>
		<script type="text/javascript" src="js/jsapi.js"></script>
		<script type="text/javascript">

			$(document).ready(function () {
			  //your code here
			 	$('#next').on("click",function() {
			  		var houseno = $("#dropdown").val();
			  		var location = $("#locid").val();
	            	window.location = "pen.php?houseno="+houseno+"&location="+location;
	       		});
	       		$('#previous').on("click",function() {
	            	window.location = "index.php";
	       		});
	       		
			});
		</script>
		<script>
			function popup(step){
				var div = document.getElementById('prompt');
				if(step=="next"){
					div.style.display ="block";
					div.style.position ="absolute";
					div.innerHTML = "Click here to proceed to next step.";	
				}else if(step=="prev"){
					div.style.display ="block";
					div.style.position ="absolute";
					div.innerHTML = "Click here to go back to previous step.";
				}
				
					
				
			}
			function hide(){
				document.getElementById('prompt').style.display = 'none';
			}
		</script>
	</body>
	
	
</html>