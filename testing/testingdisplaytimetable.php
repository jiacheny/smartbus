<?
	require_once("../API_Function.php");
	require_once("../database.php");
	
	$lineIDs = [943, 1517, 7531, 7464, 7458, 7474, 8088, 7476, 7477];
	$lineID = 7474;
	$dirID = 20;
	
	$sql = "select stop_id from linestopsorder where dir_id=$dirID and line_id=$lineID order by order_id";
	$result = getQueryResult($sql);
	$stopIDs = [];
	while ($row = mysqli_fetch_assoc($result)) {
		array_push($stopIDs, $row['stop_id']);
	}
	
	echo "StopIDs <br>";
	print_r(array_values($stopIDs));
	
	//$currentTime = date("Y-m-d\TH:i:s\Z");
	$currentTime = "2015-02-02T04:00:00Z";
	$nextday = "2015-02-02T16:00:00Z";
	echo "<br><br> current is $currentTime <br>";
	echo "<br> next is $nextday <br>";
	
	$sql = "select run_id from timetable as t, stops as s where t.stop_id=s.stop_id and time_utc>='$currentTime' and time_utc<='$nextday' order by time_utc";
	$result = getQueryResult($sql);
	$runIDs = [];
	while ($row = mysqli_fetch_assoc($result) ) {
		if (!in_array($row['run_id'], $runIDs))
			array_push($runIDs, $row['run_id']);
	}
	
	echo "<br>runIDs <br>";
	print_r(array_values($runIDs));
	
	echo "<br>";
	echo "<br>";
	
	//display timetable
	echo "<table style='border: solid'>";
	foreach ($stopIDs as $key => $value) {
		echo "<tr>";
		echo "<td>".getStopName($value)."</td>";
		foreach ($runIDs as $key2 => $value2) {
			$sql = "select t.stop_id, run_id, time_mel from timetable as t, stops as s where t.stop_id=s.stop_id and time_utc>='$currentTime' and time_utc<='$nextday' and t.stop_id=$value and run_id=$value2";
			$result = getQueryResult($sql);
			if ($row = mysqli_fetch_assoc($result)) {
				$tempTime = $row['time_mel'];
				$tempTime = date("H:i", strtotime($tempTime));
				echo "<td>".$tempTime."</td>";
			} else {
				echo "<td> X </td>";
			}
		}
		echo "</tr>";
	}
	echo "</table>";
	
	function getStopName ($stopID) {
		$sql = "select location_name from stops where stop_id=$stopID";
		$result = getQueryResult($sql);
		$row = mysqli_fetch_assoc($result);
		$stopName = $row['location_name'];
		return $stopName;
	}
	
	
	
	
?>