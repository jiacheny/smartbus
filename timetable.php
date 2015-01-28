<?php 
	require_once("API_Function.php");
	
	$line_id = 7474;
	$stop_id = 22066;
	$dir = 21;
	$utc = "2015-01-28T13:23:00Z";
	
	//SpecificNextDepartures($_line_id,$_stop_id,$_direction_id,$_time)
	echo "SpecificNextDepartures";
	SpecificNextDepartures($line_id, $stop_id, $dir, '2015-01-29T12:20:23Z');
	
	//BroadNextDepartures($_stop_id)
	echo "BroadNextDepartures";
	BroadNextDepartures($stop_id);
	
	//StopsOnLine($_line_id)
	echo "StopsOnLine";
	StopsOnLine($line_id);
?>