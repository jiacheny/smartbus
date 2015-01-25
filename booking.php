<?php
	require_once('Common_Function.php');
	
	$errorMsg = NULL;
	if(isset($_GET['searchRout']))
	{
		$_SESSION['line_id'] = $_GET['route']!="NULL"? $_GET['route']:NULL;
		$_SESSION['linedir_id'] = $_GET['direction']!="NULL"? $_GET['direction']:NULL;
		$_SESSION['date'] = $_GET['date'];
		$_SESSION['time'] = $_GET['time'];
		try
		{
			if($_SESSION['line_id'] == NULL){throw new customException("Please Select Route!");}
			if($_SESSION['linedir_id'] == NULL){throw new customException("Please Select Direction!");}
			loadRoute($_SESSION['line_id'],$_SESSION['linedir_id'],$_SESSION['date'],$_SESSION['time']);
		}
		catch(customException $e)
		{
			$errorMsg = $e->error();
		}
	}

	if(isset($_GET['submitBtn']))
	{
		$_SESSION['select'] = $_GET['bookStop']!=NULL? $_GET['bookStop']:NULL;
		try
		{
			if($_SESSION['select'] == NULL){throw new customException("Empty Selection!");}
			insertBooking($_SESSION['select']);
		}
		catch(customException $e)
		{
			$errorMsg = $e->error();
		}
	}
	if(isset($_GET['new']))
	{
		unset($_SESSION['result']);
		unset($_SESSION['line_id']);
		unset($_SESSION['linedir_id']);
		unset($_SESSION['date']);
		unset($_SESSION['time']);
		unset($_GET['submitBtn']);
	}
	if(isset($_GET['Logout']))
	{
		logout();
		header('Location: index.php');
	}
?>


<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/mystyle.css">
<script src="./js/changeSelect.js"></script>
<title>Booking</title>
</head>

<body>

<div id="container">

<?php include './include/top.inc';?>

<div id="mainContent">
	<p><b>Booking:</b></p>
<?php
	if($errorMsg == NULL && !isset($_GET['submitBtn']))
	{
?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
		
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

			<br/>
			<select name="direction" id="direction" disabled="true">
				<option selected="selected" value="NULL">(Select Direction)</option>
			</select>
				
	<!--<br/>
			<select name="stop" id="stop" disabled="true">
				<option selected="selected" value="NULL">(Select Stop)</option>
			</select>-->
			
			<br/>
			<input type="date" name="date" value="<?php echo date('Y-m-d',time());?>"/>
			<input type="time" name="time" value="<?php echo date('H:i',time());?>"/>
			
			<br/>
			<input type="submit" name="searchRout" value="Search"/>
		</form>

<?php
	}
	if($errorMsg == NULL && $_SESSION['result'] != NULL && !isset($_GET['submitBtn']))
	{
?>

		<br/>
		<form name="submitForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
			<table border="1">
<?php displaySearchRoute();?>
			</table>
			<input type="submit" name="submitBtn" value="submit"/>
		</form>

<?php
	}
	if($errorMsg == NULL && isset($_GET['submitBtn']))
	{
		echo "Confirmation:";
		echo "<br/>";
		echo "Hello, you have booked bus successfully!";
		echo "<br/>";
		echo "Please check your booking details:";
		echo "<br/>";
		echo "You booked Route: ";
		$fptr = fopen("./data/testRoute.xls", "rb");
		rewind($fptr);
		while (!feof($fptr)) {
			$string = fgets($fptr);
			$tmp = explode("\t", $string);

			if ($tmp[0] == $_SESSION['line_id']) {
				echo $tmp[1]."<br/>";
				if ($tmp [2] == $_SESSION['linedir_id']) {
					echo "Direction:".$tmp[3];
				}
				else
					echo "Direction:".$tmp[5];
				break;
			}
		}
		fclose($fptr);
		echo "<br/>";

		for ($i=0; $i < count($_SESSION['select']); $i++) { 
			for($j=0; $j < count($_SESSION['result']); $j++)
			{
				if($_SESSION['select'][$i] == $_SESSION['result'][$j]['stop_id'])
				echo "Station: ".$_SESSION['result'][$j]['location_name']." at ".$_SESSION['result'][$j]['time']."."."<br/>";
			}
		}
?>

	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
		<input type="submit" name="new" value="Make a new Booking!"/>
	</form>

	<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
		<input type="submit" name="Logout" value="logout"/>
	</form>

<?php
	}																																						
	if($errorMsg != NULL)
	{
		echo $errorMsg;
		echo "<br/>";
		echo "<a href='booking.php'>Try again</a>";
	}
?>
</div>

<?php include './include/footer.inc';?>

</div>

</body>
</html>