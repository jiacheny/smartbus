<?php
	require_once("../API_Function.php");
	require_once("../database.php");
	
	
	
	date_default_timezone_set("UTC");
	$time = date('Y-m-d\TH:i:s\Z');
	echo "UTC time is ".$time."<br>";
	$melTime = utcToMel ($time);
	echo "MEL time is ".$melTime."<br>";
	$bookingUTCTime = date("Y-m-d\TH:i:s\Z",strtotime($time));
	echo "bookingUTCTime is ".$bookingUTCTime."<br>";

	
	
	
	
	
	
	
	
	
?>