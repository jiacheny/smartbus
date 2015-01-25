<?php
	require_once('Common_Function.php');

	$errorMsg = NULL;	
	if(isset($_GET['submit']))
	{
		$line_id = $_GET['route']!="NULL"? $_GET['route']:NULL;
		$dir_id = $_GET['direction']!="NULL"? $_GET['direction']:NULL;
		$filename = $_GET['job']!="NULL"? $_GET['job']:NULL;
		$driver = $_GET['driver']!="NULL"? $_GET['driver']:NULL;
		try{
			if($line_id == NULL){throw new customException("Please Select Route!");}
			if($dir_id == NULL){throw new customException("Please Select Direction!");}
			if($filename == NULL){throw new customException("Please Select Job!");}
			if($driver == NULL){throw new customException("Please Select Driver!");}
			assignJob($line_id,$dir_id,$filename,$driver);
		}
		catch(customException $e)
		{
			$errorMsg = $e->error();
		}
	}
	if(isset($_GET['back']))
	{
		session_destroy();
		header('Location: index.php');
	}
?>
<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/mystyle.css">
<script src="./js/assignJob.js"></script>
<title>Assign Job</title>
</head>

<body>

<div id="container">

<?php include './include/top.inc';?>


<div id="mainContent">
	<p><b>Assign Driver Job:</b></p>

<?php
	if(!isset($_GET['submit']))
	{
?>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
			<table border="1">
				<tr>
					<th>Route</th>
					<th>Direction</th>
					<th>Jobs</th>
					<th>Driver</th>
				</tr>
				<tr>
					<td>
						<select name="route" id="route" onchange="changeDir(this.value)">
							<option selected="selected" value="NULL">(Select Route)</option>
				<?php
							if(!file_exists("./data/testRoute.xls"))
								die("File not found!");
							else
							{
								$fp = fopen("./data/testRoute.xls","rb");
								rewind($fp);
								
								while(!feof($fp))
								{
									$string = fgets($fp);
									$tmp = explode("\t",$string);
									
									echo "<option value='$tmp[0]'>$tmp[1]</option>";
								}
							}
				?>
						</select>
					</td>
					
					<td>
						<select name="direction" id="direction" disabled="true" onchange="showJob(this.value)">
							<option selected="selected" value="NULL">(Select Direction)</option>
						</select>
					</td>

					<td>
						<select name="job"	id="job" disabled="true">
							<option selected="selected" value="NULL">(Select Job)</option>
						</select>
					</td>

					<td>
						<select name="driver" id="driver">
							<option selected="selected" value="NULL">(Select Driver)</option>
							<option value="D001">D001</option>
							<option value="D002">D002</option>
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" name="submit" value="Assign"/>
		</form>

<?php
	}
	elseif(isset($_GET['submit']) && $errorMsg == NULL) {
?>
	<p>Insert Successfully!!!</p>
	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
		<input type="submit" name="Back" value="Back"/>
	</form>
<?php
	}
	else
	{
		echo "$errorMsg";
		echo "<br/>";
		echo "<a href='assignDriverJob.php'>Try again</a>";
	}
?>

</div>

<?php include './include/footer.inc';?>

</div>

</body>
</html>