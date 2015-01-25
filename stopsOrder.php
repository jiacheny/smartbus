<!--writen by ran jing  -->
<?php
	require_once("API_Function.php");
	require_once("dataReaderFunction.php");
?>

<!DOCTYPE html>
<html>

<head>
	<title> Generate Stops</title>
	<script type="text/javascript">
		console.log("HELLO");
	</script>
</head>

<body>

	


	<div> 
		<?php
			$lineID = 7474;
			$stops = StopsOnLine($lineID);
			$stopsidArray = [];
			$content = "";

			echo "Start for lop below. <br>";
			

				
				$test = StoppingPattern(43320,$stops[0]["stop_id"],date('2015-01-26\Z'));									
				$test = reset($test);
								
				foreach($test as $key => $value){
					
					if(count($value)!=0 && !in_array($value["platform"]["stop"]["stop_id"],$stopsidArray)){
						
						$content = $content.$value["platform"]["stop"]["stop_id"];
						$content = $content."\n";
						array_push($stopsOrderArray,$value["platform"]["stop"]["stop_id"]);
						$dirID = $value["platform"]["direction"]["direction_id"];
						
					}
				}
			
					
			$file = fopen("data/stops/regular/".$lineID."/route".$dirID.".xls",w);
			fwrite($file, $content);
			fclose($file);
								
		?>

	</div>

	

</body>


</html>