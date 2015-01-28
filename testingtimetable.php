<?php
	include("API_Function.php");
	
	$lineID = 7474;
	$time = "2015-01-28T13:01:00Z";
	echo "time is $time <br>";
	$dirID = 20;
	//SpecificNextDepartures($lineID, 22066, $dirID, $_time);
	generateTimetable($lineID,$dirID,$time);
	
	
?>