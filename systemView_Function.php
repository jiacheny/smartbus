<?php
	// this file is written by Jiachen Yan
	function showLineRouteNumber() {	
		$file = fopen("data/lineinfo.xls", r);
		rewind($file);
		while(!feof($file)){
			$string = fgets($file); 
			$temp = explode("\t", $string);
			echo "<button class='pure-button'> <i class='fa fa-bus'></i> $temp[1] </button>";
		}
		fclose($file);
	}
	
	function getDirectionInfo($routeNumber) {
		$file = fopen("data/lineinfo.xls", r);
		rewind($file);
		$dirinfo = "";
		while(!feof($file)){
			$string = fgets($file); 
			$temp = explode("\t", $string);
			if ($temp[1]==$routeNumber) {
				$dirinfo = "<p> <button id='dirA' class='pure-button' name=$temp[0] value=$temp[3]> $temp[4] </button> </p><p><button id='dirB' class='pure-button' name=$temp[0] value=$temp[5]> $temp[6] </button></p>";
			}
		}
		fclose($file);
		echo json_encode($dirinfo);
	}
	
	function getRegularStopsLocation($lineID, $dirID) {
		$test;
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
		$test;
		$filepath = "data/stops/optional/$lineID/$dirID.xls";
		$stopsLocation = [];
		if (file_exists($filepath)) {
			$file = fopen($filepath, rb);
			rewind($file);
			while(!feof($file)){
				$oneline = fgets($file);
				$temp = explode("\t", $oneline);
				array_push($stopsLocation, [trim($temp[0]), floatval(trim($temp[1])), floatval(trim($temp[2]))]);
			}
			fclose($file);
		}
		echo json_encode($stopsLocation);
	}
	
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
	
	
	if (isset($_POST['getDirectionInfo'])) { getDirectionInfo($_POST['getDirectionInfo']); }
	if (isset($_POST['getRegularStopsLocation'])) { getRegularStopsLocation($_POST['getRegularStopsLocation'][0], $_POST['getRegularStopsLocation'][1]); }
    if (isset($_POST['getOptionalStopsLocation'])) { getOptionalStopsLocation($_POST['getOptionalStopsLocation'][0], $_POST['getOptionalStopsLocation'][1]); }
	
	
	
	
?>