<?php
	require_once('../API_Function.php');
	require_once('../Booking_Function.php');
	
	$bookingTime ="2015-02-09T11:30:00Z";
	echo "booking time is $bookingTime <br>";
	date_default_timezone_set("UTC");
	$bookingTime = date('Y-m-d H:i:s',strtotime($bookingTime));	
	echo "booking time to utc is $bookingTime <br>";	
	$bookingUTCTime = MelToutc($bookingTime);
	echo "bookingUTCTime is $bookingUTCTime <br>";
	
	$check = checkTimetable (7474, 21, $bookingTime);
	echo "check = $check";
	
	
	
?>