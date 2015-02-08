<?php
	require_once("../API_Function.php");
	require_once("../database.php");
	require_once("../Booking_Function.php");
	
	
	
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
	
	
	/*echo "start <br>";
	$testdate = date('Y-m-d\TH:i:s\Z');
	echo "test date is".$testdate."<br>";
	$meltestdate = utcToMelDate ($testdate);
	echo "mel test date is ".$meltestdate."<br>";
	$tomorrow = utcToMelDate(date("Y-m-d\TH:i:s\Z", strtotime("+1 day"))); 
	echo "tomorrow is ".$tomorrow."<br>";*/
	date_default_timezone_set("UTC");
	$bookingTime = "2015-02-09T17:00:00Z";
	$temptime = strtotime($bookingTime);
	$starttime = date('Y-m-d H:i:s',strtotime('-15 minutes', $temptime));
	echo "start time is ".$starttime."<br>";
	$endtime = date('Y-m-d H:i:s',strtotime('+60 minutes', $temptime));
	echo "end time is ".$endtime."<br>";
	
		
		/*$lineID = 7474;
		$dirID = 21;
		$optID = 3;		
		$bookingTime = "2015-02-09T17:00:00Z";	
		date_default_timezone_set("UTC");
		$bookingTime = date('Y-m-d H:i:s',strtotime($bookingTime));			
		$bookingUTCTime = MelToutc($bookingTime);
		echo "booking utc time is ".$bookingUTCTime."<br>";*/
		/*$check = checkTimetable ($lineID, $dirID, $bookingTime); 
		echo $check."<br>";
		if($check){
			$html = displayTimetable($lineID, $dirID, $optID, $bookingTime);
		} else {			
			generateTimetable($lineID, $dirID, $bookingUTCTime);
			$html = displayTimetable($lineID, $dirID, $optID, $bookingTime);
		}*/
		
	
	
	?>