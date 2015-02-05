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
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<link rel="stylesheet" type="text/css" href="./css/mystyle.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/booking.js"></script>
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
							<select class="searchSelect" id="selectLine"> 
								<option> Select A Bus Line </option>
								<?php selectLineNumber() ?>
							</select>
						</div>
						<div>
							<label class="searchLabel"> Direction </label>
							<select class="searchSelect" id="selectDirection">
								<option> Select A Direction </option>
							</select>
						</div>
						<div>
							<label class="searchLabel"> Optional Stop </label>
							<select class="searchSelect" id="selectStops">
								<option> Select An Optional Stop </option>
							</select>
						</div>
						<div>
							<label class="searchLabel"> Date </label>
							<select class="searchSelect" id="selectDate">
								<option> Select A Date </option>
								<option value="2015-02-03" > Today </option>
								<option value="2015-02-04"> Tomorrow </option>
							</select>
						</div>
						<div>
							<label class="searchLabel"> Time </label>
							<div class="searchSelect">
								<select id="selectHour">
									<option value=00> 00 </option>
									<option value=01> 01 </option>
									<option value=02> 02 </option>
									<option value=03> 03 </option>
									<option value=04> 04 </option>
									<option value=05> 05 </option>
									<option value=06> 06 </option>
									<option value=07> 07 </option>
									<option value=08> 08 </option>
									<option value=09> 09 </option>
									<option value=10> 10 </option>
									<option value=11> 11 </option>
									<option value=12> 12 </option>
									<option value=13> 13 </option>
									<option value=14> 14 </option>
									<option value=15> 15 </option>
									<option value=16> 16 </option>
									<option value=17> 17 </option>
									<option value=18> 18 </option>
									<option value=19> 19 </option>
									<option value=20> 20 </option>
									<option value=21> 21 </option>
									<option value=22> 22 </option>
									<option value=23> 23 </option>
								</select>
								<label> : </label>
								<select id="selectMinute">
									<option value=00> 00 </option>
									<option value=15> 15 </option>
									<option value=30> 30 </option>
									<option value=45> 45 </option>
								</select>
							</div>
						</div>
						<div>
							<input type="button" id="searchBtn" class="pure-button pure-button-primary" value="Search">
				        </div>
					</form>
					<div id="timetable"> </div>
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