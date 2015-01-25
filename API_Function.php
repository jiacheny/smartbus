<?php
	//Get Data from PTV timetable API
	function getData($_midURL)
	{
		//Set key, id and base url
		//$_devid = "1000284";
		//$_key = "77cce398-3fbf-11e4-8bed-0263a9d0b8a0";
		$_devid = "1000326";
		$_key = "48f9d380-84d1-11e4-a34a-0665401b7368";	
		$_baseURL = "http://timetableapi.ptv.vic.gov.au";
		
		/*
		 *Set signature. Using HMAC-SHA1 hash of the completed request(minus the
		 *base URL but including developer ID.
		 */
		if(strpos($_midURL, '?') > 0)
			$_midURL .= "&devid=".$_devid;
		else
			$_midURL .= "?devid=".$_devid;
		
		$_signature = hash_hmac("sha1",$_midURL,$_key);
		
		/*
		 *Set full request URL
		 */
		$_URL = $_baseURL.$_midURL."&signature=".$_signature;
		echo "<br> $_URL <br>";

		//Get response as json object and return.
		$_content = file_get_contents($_URL);
		$_content = json_decode($_content,true);
		
		return $_content;
	}
	
	//find all stops for a specific line
	function StopsOnLine($_line_id)
	{
		$_midURL = "/v2/mode/2/line/$_line_id/stops-for-line";
		$_content = getData($_midURL);
		
		return $_content;
	}
	
	//
	function BroadNextDepartures($_stop_id)
	{
		$_midURL = "/v2/mode/2/stop/$_stop_id/departures/by-destination/limit/0";
		$_content = getData($_midURL);
		
		return $_content;
	}
	
	//
	function SpecificNextDepartures($_line_id,$_stop_id,$_direction_id,$_time)
	{
		$_midURL = "/v2/mode/2/line/$_line_id/stop/$_stop_id/directionid/$_direction_id/departures/all/limit/0?for_utc=$_time";
		$_content = getData($_midURL);
		
		return $_content;
	}
	
	function StoppingPattern($_run_id,$_stop_id,$_time)
	{
		$_midURL = "/v2/mode/2/run/$_run_id/stop/$_stop_id/stopping-pattern?for_utc=$_time";
		$_content = getData($_midURL);
		
		return $_content;
	}
	
	function generateTimetable($lineID,$dirID,$time){
			
			$content = "";
			$stopsOrderArray = [];
			$timetableArray = [];
			
			$file = fopen("data/stops/regular/".$lineID."/route".$dirID.".xls",r);
			rewind($file);
			while(!feof($file)){
				$oneline = fgetss($file);
				$oneline = trim($oneline);
				array_push($stopsOrderArray,$oneline); 
			}				
					
			for ($i=0; $i<count($stopsOrderArray); $i++) {
					
					$temp = SpecificNextDepartures($lineID,$stopsOrderArray[$i],$dirID,$time);				
					$temp = reset($temp);
				
					foreach($temp as $key => $value){

						$timetableUTCTime = $value["time_timetable_utc"];
						$temptime = strtotime($timetableUTCTime);
						date_default_timezone_set("Australia/Melbourne");
						$dateInLocal = date('Y-m-d\TH:i:s\Z',$temptime);						
						$a = $value['run']['run_id'];
						$timeArray[$a] = [];
						array_push($timeArray[$a],$dateInLocal);
						$timetableArray[$stopsOrderArray[$i]] = [];
						array_push($timetableArray[$stopsOrderArray[$i]],$timeArray);						
						
					}
					
			}
			
			foreach($timetableArray as $key => $value){
				
				$content = $content.$key;
				
				foreach($timeArray as $key => $value){
					
					$content = $content."\t".$key;
					$content = $content."\t".$value[0];
					
				}
				
				$content = $content."\n";
				
			}

			$filename = date('Ymd');
			$tempfile = fopen("data/timetable/".$lineID."/".$dirID."/".$filename.".xls",w);
			fwrite($tempfile, $content);			
			fclose($tempfile);
			
	}
	
?>