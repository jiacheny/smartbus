<?php
	require_once('Common_Function.php');
	
	$errorMsg = NULL;
	if(isset($_GET['searchRout'])) {
		$_SESSION['line_id'] = $_GET['route']!="NULL"? $_GET['route']:NULL;
		$_SESSION['linedir_id'] = $_GET['direction']!="NULL"? $_GET['direction']:NULL;
		$_SESSION['date'] = $_GET['date'];
		$_SESSION['time'] = $_GET['time'];
		try {
			if($_SESSION['line_id'] == NULL){throw new customException("Please Select Route!");}
			if($_SESSION['linedir_id'] == NULL){throw new customException("Please Select Direction!");}
			loadRoute($_SESSION['line_id'],$_SESSION['linedir_id'],$_SESSION['date'],$_SESSION['time']);
		}
		catch(customException $e) {
			$errorMsg = $e->error();
		}
	}

	if(isset($_GET['submitBtn'])) {
		$_SESSION['select'] = $_GET['bookStop']!=NULL? $_GET['bookStop']:NULL;
		try {
			if($_SESSION['select'] == NULL){throw new customException("Empty Selection!");}
			insertBooking($_SESSION['select']);
		}
		catch(customException $e) {
			$errorMsg = $e->error();
		}
	}
	
	if(isset($_GET['new'])) {
		unset($_SESSION['result']);
		unset($_SESSION['line_id']);
		unset($_SESSION['linedir_id']);
		unset($_SESSION['date']);
		unset($_SESSION['time']);
		unset($_GET['submitBtn']);
	}
	if(isset($_GET['Logout'])) {
		logout();
		header('Location: index.php');
	}
?>


<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="./css/mystyle.css">
		<script src="js/booking.js"></script>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<title>Booking</title>
	</head>

	<body>
		<div style="background-color: white">
			<?php include './include/top.inc';?>
			<p><h2 style="text-align: center">BOOKING</h2></p>
			<?php
			if ( $errorMsg == NULL && !isset($_GET['submitBtn']) ) {
			?>
				<div id="searchdiv">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" id='searchform'>
						<div>
							<label class="searchLabel"> Bus Line </label>
							<select class="searchSelect"> 
								<option> Select A Bus Line </option>
								<?php selectLineNumber() ?>
							</select>
						</div>
						<div>
							<label class="searchLabel"> Direction </label>
							<select class="searchSelect">
								<option> Select A Direction </option>
							</select>
						</div>
						<div>
							<label class="searchLabel"> Optional Stop </label>
							<select class="searchSelect">
								<option> Select A Optional Stop </option>
							</select>
						</div>
						<div>
							<label class="searchLabel"> Time </label>
							<select class="searchSelect">
								<option> Select A Time </option>
							</select>
						</div>
						<div>
				            <button type="submit" id="searchSubmit" class="pure-button pure-button-primary">Submit</button>
				        </div>
					</form>
				</div>
			
			<?php
			}
			if($errorMsg == NULL && $_SESSION['result'] != NULL && !isset($_GET['submitBtn'])) {
			?>
			
				<br/>
				<form name="submitForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
					<table border="1">
					<?php displaySearchRoute(); ?>
					</table>
					<input type="submit" name="submitBtn" value="submit"/>
				</form>
			
			<?php
				}
				if($errorMsg == NULL && isset($_GET['submitBtn'])) {
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
						for($j=0; $j < count($_SESSION['result']); $j++) {
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
				if($errorMsg != NULL) {
					echo $errorMsg;
					echo "<br/>";
					echo "<a href='booking.php'>Try again</a>";
				}
			?>
			</div>
			
			<?php include './include/footer.inc';?>
			
			</div>
		</div>
	</body>
</html>