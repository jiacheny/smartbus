<?php
	
	require_once '../API_Function.php';
	
	$lineIDs = [943, 1517, 7531, 7464, 7458, 7474, 8088, 7476, 7477];
	$lineID = 7474;
	$stopID = 22066;
	$dirID = 33;
	$time = "2015-01-31T09:00:00Z";
	
	BroadNextDepartures($stopID);
	SpecificNextDepartures($lineID,$stopID,$dirID,$time);
	
	
	
?>