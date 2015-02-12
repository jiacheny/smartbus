<?php
	require_once('API_Function_testing.php');
		
	date_default_timezone_set("UTC");
	$bookingTime_utc = date("Y-m-d\TH:i:s\Z");
	$constraint_utc = date("Y-m-d\TH:i:s\Z", strtotime("+15 minutes"));
	$bookingTime = utcToMel ($bookingTime_utc);
	$constraint = utcToMel ($constraint_utc);
	$arrivaltime = "2015-02-12T20:02:00Z";
	
	echo "bookingTime = $bookingTime <br>";
	echo "constraint = $constraint <br>";
	echo "arrivaltime = $arrivaltime <br>";
	
	if (strtotime($arrivaltime) > strtotime($constraint))
		echo "arrival > cons";
	else
		echo "arrival <= cons";
?>