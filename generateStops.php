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
						$content = $content."\t".$value["platform"]["stop"]["suburb"];
						$content = $content."\t".$value["platform"]["stop"]["location_name"];
						$content = $content."\t".$value["platform"]["stop"]["lat"];
						$content = $content."\t".$value["platform"]["stop"]["lon"];
						$content = $content."\n";
						array_push($stopsidArray,$value["platform"]["stop"]["stop_id"]);
						
					}
				}
			}
			
			
			$file = fopen("data/stops/regular/".$lineID."/".$dir.".xls",w);
			fwrite($file, $content);
			fclose($file);
								
		?>

	</div>

	

</body>


</html>