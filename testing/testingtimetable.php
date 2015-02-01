<?php
	require("../API_Function.php");
	
	$lineID = 7474;
	$time = "2015-02-02T09:00:00Z";
	$dirID = 33;
	generateTimetable($lineID,$dirID,$time);
	
	/*
	displayTimetable ($lineID, $dirID, $time);

	function displayTimetable ($lineID, $dirID, $time) {
		$file = fopen("$time.xls", r);
		rewind($file);
		echo "<table>";
		$stopsIDName = getStopNameArray ($lineID, $dirID);
		while (!feof($file)) {
			$oneline = fgets($file);
			$temp = explode("\t", $oneline);
			echo "<tr>";
			echo "<td>".$stopsIDName[$temp[0]]."</td>";
			$temp[2] = utcToMel ($temp[2]);
			echo "<td> $temp[2] </td>";
			echo "</tr>";
		}
		echo "</table>";
		fclose($file);
	}
	
	function getStopNameArray ($lineID, $dirID) {
		$file =fopen("data/stops/regular/$lineID/$dirID.xls", r);
		rewind($file);
		$stopsIDName = [];
		while (!feof($file)) {
			$oneline = fgets($file);
			$temp = explode("\t", $oneline);
			$stopsIDName[$temp[0]] = $temp[2];
		}
		fclose($file);
		return $stopsIDName;
	}
	
	*
	
?>