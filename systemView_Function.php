<?php
	
	// this file is written by Jiachen Yan
	function showLineRouteNumber() {
		$sql = "select line_number from line order by line_number";
		$result = getQueryResult($sql);
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<button class='pure-button'> <i class='fa fa-bus'></i> ".$row['line_number']." </button>";
		}
		mysqli_free_result($result);
	}
	
	function getDirectionInfo($lineNumber) {
		include 'database.php';
		$sql ="select b.line_id, line_number, b.dir_id, b.dir_name from line as a, direction as b where a.line_id = b.line_id and line_number=$lineNumber";
		$result = getQueryResult($sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$dirinfo = $dirinfo."<p><button class='pure-button'>".$row['dir_name']." </button></p>";
		}
		echo json_encode($dirinfo);
	}
	
	function getRegularStopsLocation($lineID, $dirID) {
		$filepath = "data/stops/regular/$lineID/$dirID.xls";
		$stopsLocation = [];
		if (file_exists($filepath)) {
			$file = fopen($filepath, rb);
			rewind($file);
			while(!feof($file)){
				$oneline = fgets($file);
				$temp = explode("\t", $oneline);
				array_push($stopsLocation, [trim($temp[2]), floatval(trim($temp[3])), floatval(trim($temp[4]))]);
			}
			fclose($file);
		}
		echo json_encode($stopsLocation);
	}
	
	function getOptionalStopsLocation($lineID, $dirID) {
		$filepath = "data/stops/optional/$lineID/$dirID.xls";
		$stopsLocation = [];
		if (file_exists($filepath)) {
			$file = fopen($filepath, rb);
			rewind($file);
			while(!feof($file)){
				$oneline = fgets($file);
				$temp = explode("\t", $oneline);
				array_push($stopsLocation, [trim($temp[1]), floatval(trim($temp[2])), floatval(trim($temp[3]))]);
			}
			fclose($file);
		}
		echo json_encode($stopsLocation);
	}
	
	if (isset($_POST['getDirectionInfo'])) { getDirectionInfo($_POST['getDirectionInfo']); }
	if (isset($_POST['getRegularStopsLocation'])) { getRegularStopsLocation($_POST['getRegularStopsLocation'][0], $_POST['getRegularStopsLocation'][1]); }
    if (isset($_POST['getOptionalStopsLocation'])) { getOptionalStopsLocation($_POST['getOptionalStopsLocation'][0], $_POST['getOptionalStopsLocation'][1]); }
	
	
	//temp use for testing
	function ran($lineID, $dirID) {
		$test;
		$filepath = "data/stops/regular/$lineID/$dirID.xls";
		$stopsLocation = [];
		if (file_exists($filepath)) {
			$file = fopen($filepath, rb);
			rewind($file);
			while(!feof($file)){
				$oneline = fgets($file);
				$temp = explode("\t", $oneline);
				array_push($stopsLocation, [$temp[0], floatval(trim($temp[3])), floatval(trim($temp[4]))]);
			}
			fclose($file);
		}
		echo json_encode($stopsLocation);
	}
	if (isset($_POST['ran'])) { ran($_POST['ran'][0], $_POST['ran'][1]); }
	
	
	
	
?>