<!Doctype html>
<!-- written by Jiachen Yan -->
<?php require("systemView_Function.php");  ?>

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./css/mystyle.css"/>
		<link rel="stylesheet" type="text/css" href="./css/font-awesome-4.3.0/css/font-awesome.min.css"/>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/systemView.js"></script>
		<title>System View</title>
	</head>

	<body>
			
		<div style="background-color: white">
			
			<?php include './include/top.inc';?>
			<div style="text-align: center">
				<h2>System View</h2>
				<div id="routenumberinfo"> <?php showLineRouteNumber(); ?> </div>
				<div id="directioninfo" style="margin: auto;"></div>
			</div>
			<?php include './include/footer.inc';?>
			
		</div>
	
	</body>
	
</html>