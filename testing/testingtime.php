<?php
	require_once("../API_Function.php");
	require_once("../database.php");
	
	
	
	//date_default_timezone_set("Australia\Melbourne");
	//$timetest = date('Y-m-d\TH:i:s\Z');

	//$utc = date('Y-m-d\TH:i:s\Z', strtotime($timetest));	
	
	//echo "UTC time is ".$utc."<br>";
	//echo "MEL time is ".$mel."<br>";
	//echo "time test is ".$timetest."<br>";
	
	/*$melTime = utcToMel ($timetest);
	echo "MEL time is ".$melTime."<br>";
	$bookingUTCTime = date("Y-m-d\TH:i:s\Z",strtotime($timetest));
	echo "bookingUTCTime is ".$bookingUTCTime."<br>";
	*/
	/*date_default_timezone_set("UTC");
	$testtime = "2015-02-15T09:00:00Z";
	echo "test time is ".$testtime."<br>";
	$testtime = strtotime($testtime);
	$starttime = date('Y-m-d\TH:i:s\Z',strtotime('-15 minutes', $testtime));
	echo "start time is ".$starttime."<br>";	
	$endtime = date('Y-m-d H:i:s',strtotime('+60 minutes', $testtime));
	echo "end time is ".$endtime."<br>";	
	*/
	
	
	echo "start <br>";
	date_default_timezone_set("UTC");
	$bookingTime = "2015-02-09T09:00:00Z";
	$temptime = strtotime($bookingTime);
	$starttime = date('Y-m-d H:i:s',strtotime('-15 minutes', $temptime));
	echo "start time is ".$starttime."<br>";
	$endtime = date('Y-m-d H:i:s',strtotime('+60 minutes', $temptime));
	echo "end time is ".$endtime."<br>";
	?>