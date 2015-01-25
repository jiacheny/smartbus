<?php
	if(isset($_GET['Back']))
	{
		unset($_GET['job']);
	}
?>

<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/mystyle.css"/>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="./js/routeTree.js"></script>
<?php
	if(isset($_GET['job']))
	{
?>

<script>
	function init(){
		var i=0;
		var blue = "./images/bluemarker.png";
		var posit = new Array();
		var point = new Array();
		var marker = new Array();
<?php
		$fp = fopen($_GET['job'], "r");
		rewind($fp);

		$string = fgets($fp);
		while (!feof($fp)) {
			$string	= fgets($fp);
			$tmp = explode("\t", $string);
			echo 'point[i] = new Array();';
			echo 'point[i][0] = new google.maps.LatLng('.$tmp[2].','.$tmp[3].');';
			echo 'point[i++][1] = "'.trim($tmp[4]).'";';
		}
?>
		var mapOptions = {
			zoom: 13,
			center: point[0][0]
		}

		var route = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

		for (var i = 0; i < point.length; i++) {
			if (point[i][1].match("Optional") != null) {
				marker[i] = new google.maps.Marker({
					position: point[i][0],
					icon: blue,
					map: route
				});
			}
			else
			{
				marker[i] = new google.maps.Marker({
					position: point[i][0],
					map: route
				});
			}
		}
	}
	google.maps.event.addDomListener(window, 'load', init);
</script>

<?php
	}
?>
<title>System View</title>
</head>

<body>

<div id="container">

<?php include './include/top.inc';?>

<div id="mainContent">
	<p><b>System View:</b></p>
<?php
	if(!isset($_GET['job']))
	{
?>

<div class="tree">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
<?php
	$fp = fopen("./data/testRoute.xls","r");
	rewind($fp);

	echo '<ul>';
	while (!feof($fp)) {
		$string = fgets($fp);
		$tmp = explode("\t", $string);

		echo '<li>'.'<a>'.$tmp[1].'</a>';	
			echo '<ul style="display:none">';
				echo '<li>'.'<a>'.$tmp[3].'</a>';

					echo '<ul style="display:none">';
					$reg = "/\.xls$/";
					$file = scandir("./schedule/".$tmp[0]."/".$tmp[2]);
					foreach ($file as $value) {
						if (preg_match($reg, $value)) {
							echo '<li>'.'<a>';
							echo "<input type='radio' name='job' id='$tmp[2]$value' value='./schedule/$tmp[0]/$tmp[2]/$value' style='display:none'/><label for='$tmp[2]$value'>".$value."</label>";
							echo '</a></li>';
						}
					}
					echo '</ul>';

				echo '</li>';
				echo '<li>'.'<a>'.$tmp[5].'</a>';

					echo '<ul style="display:none">';
					$reg = "/\.xls$/";
					$file = scandir("./schedule/".$tmp[0]."/".$tmp[4]);
					foreach ($file as $value) {
						if (preg_match($reg, $value)) {
							echo '<li>'.'<a>';
							echo "<input type='radio' name='job' id='$tmp[4]$value' value='./schedule/$tmp[0]/$tmp[4]/$value' style='display:none'/><label for='$tmp[4]$value'>".$value."</label>";
							echo '</a></li>';
						}
					}
					echo '</ul>';

				echo '</li>';
			echo '</ul>';
		echo '</li>';
	}
	echo '</ul>';
	fclose($fp);
?>
	</form>
</div>

<?php
	}
	else
	{
?>

	<div id="map-canvas"></div>
	<br/>
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
		<input type="submit" name="Back" value="Back"/>
	</form>

<?php
	}
?>

</div>

<?php include './include/footer.inc';?>

</div>

</body>
</html>