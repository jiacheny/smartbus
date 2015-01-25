<!--writen by ran jing  -->
<?php
	require_once("API_Function.php");
?>
<!DOCTYPE html>
<html>

<head>
	<title> TESTING FOR TIMETABLE 905</title>
	<script type="text/javascript">
		console.log("HELLO");
	</script>
</head>

<body>


	<div> 
		<?php
			
			
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
			
			generateTimetable(7474,34,date('Y-m-d\TH:i:s\Z'));				
		?>

	</div>

	

</body>


</html>