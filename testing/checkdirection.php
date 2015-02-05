<?php
	
	require_once '../API_Function.php';
	
	$lineIDs = [943, 1517, 7531, 7464, 7458, 7474, 8088, 7476, 7477];
	$dirIDs =[];
	$lineID = 7474;
	
	$stops = StopsOnLine($lineID);

	for ($i=0; $i<1; $i++) {
		$stopID = $stops[$i]['stop_id'];
		echo $stopID,"<br>";
		$bnd = BroadNextDepartures($stopID);
		$bnd = reset($bnd);
		foreach ($bnd as $key => $value) {
			$dirID = $value["platform"]["direction"]["direction_id"];
			$dirName = $value["platform"]["direction"]["direction_name"];
			if ($value['platform']['direction']['line']['line_id']==$lineID && !in_array($dirID, $dirIDs)) {
				array_push($dirIDs, $dirID);
				if (count($dirIDs)==2) {break;}
			}
			
			
		}
	}
	
	print_r(array_values($dirIDs));
	
?>