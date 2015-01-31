<?php
	
	require_once '../API_Function.php';
	
	$lineIDs = [943, 1517, 7531, 7464, 7458, 7474, 8088, 7476, 7477];
	$dirIDs =[];
	$lineID = 7458;
	
	$stops = StopsOnLine($lineID);

	for ($i=0; $i<count($stops); $i++) {
		$stopID = $stops[$i]['stop_id'];
		echo $stopID,"<br>";
		$bnd = BroadNextDepartures($stopID);
		$bnd = reset($bnd);
		foreach ($bnd as $key => $value) {
			$dirID = $value["platform"]["direction"]["direction_id"];
			if ($value['platform']['direction']['line']['line_id']==$lineID && !in_array($dirID, $dirIDs)) {
				array_push($dirIDs, $dirID);
			}
		}
	}
	
	print_r(array_values($dirIDs));
	
?>