<!--writen by ran jing  -->
<?php
	require_once("API_Function.php");
	require_once("dataReaderFunction.php");
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
			$lineID = 7474;
			$dir = 34;
			$stops = StopsOnLine($lineID);
			$stopsidArray = [];
			$content = "";

			echo "Start for lop below. <br>";
			
			for ($i=0; $i<count($stops); $i++) {
				
				$test = SpecificNextDepartures($lineID,$stops[$i]["stop_id"],$dir,date('2015-01-25\Z'));						
				$test = reset($test);
				
				foreach($test as $key => $value){
					
					if(count($value)!=0 && !in_array($value["platform"]["stop"]["stop_id"],$stopsidArray)){
						
						$content = $content.$value["platform"]["stop"]["stop_id"];
						//$content = $content."\t".$value["run"]["run_id"];					
						//$timetableUTCTime = $value["time_timetable_utc"];
						//$time = strtotime($timetableUTCTime);
						//date_default_timezone_set("Australia/Melbourne");
						//$dateInLocal = date('Y-m-d\TH:i:s\Z',$time);
						
						//$content = $content."\t".$dateInLocal."\n";						array_push($stopsidArray,$value["platform"]["stop"]["stop_id"]);
						
					}
				}
			}
			$datetime = new DateTime('tomorrow');
			echo "date",$datetime->format('Ymd');
			//$file = fopen("data/timetable/".$lineID."/".$dir."/".date().".xls",w);
			//fwrite($file, $content);
			//fclose($file);
								
		?>

	</div>

	

</body>


</html>