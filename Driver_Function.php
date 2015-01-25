<?php
	session_start();
	//Driver login function
	function driverLogin($driverId,$password)
	{
		//Set the status = false
		$_SESSION['driver']['status'] = false;
		
		//Check file is exists
		if(file_exists("./account/driverList.xls"))
		{
			//open file
			$fp = fopen("./account/driverList.xls","rb");
			rewind($fp);
			
			//check id and password
			while(!feof($fp))
			{
				$string = fgets($fp);
				$tmp = explode("\t",$string);
				
				if($driverId == $tmp[0])
				{
					if(trim($password) == trim($tmp[1]))
					{
						if (!isset($_SESSION['driver']['id'])) {
							$_SESSION['driver']['id'] = trim($tmp[0]);
						}
						
						$_SESSION['driver']['status'] = true;
					}
				}
			}
			fclose($fp);
			
			//if invalid throw exception
			if($_SESSION['driver']['status'] == false)
				throw new customException("Invalid ID or Password!");
		}
		else
			throw new customException("File not found!");
	}
	
	function loadDriverRoute($mode)
	{
		$job = false;
		$_date = date("Ymd",time());
		$_time = date("Hi",time());
		$_week = date("w",time());
		//set the file path
		if($_week == "0" || $_week == "6")
			$timetable = "./timetable/".$_SESSION['driver']['id']."/".$_week."/list.xls";
		else
			$timetable = "./timetable/".$_SESSION['driver']['id']."/list.xls";
		
		if (file_exists($timetable)) {
			$fp = fopen($timetable, "rb");
			rewind($fp);

			while (!feof($fp)) {
				$string = fgets($fp);
				$tmp = explode("\t", $string);

				if (strtotime($_time) <= strtotime(trim($tmp[4]))) {
					$job = true;
					$line_id = $tmp[1];
					$line_dir = $tmp[2];
					$line_time = $tmp[3];
					break;
				}
			}
		} 
		else 
		{
			die($timetable."-> File not found!");
		}
		
		if ($job == true) {

			$_filename = "./schedule/".$line_id."/".$line_dir."/".$_date.str_replace(':', '', trim($line_time)).".xls";
			
			if(file_exists($_filename))
			{
				$fp = fopen($_filename,"rb");
				rewind($fp);
				
				for ($j=0; !feof($fp); $j++) {
					$string = fgets($fp);
					$tmp = explode("\t", $string);

					if($j == 0)
					{
						$response .= trim($tmp[0]);
						$response .= ",".trim($tmp[1]);
						$response .= ",".trim(date("Y-m-d",time()));
					}
					else
						if ($tmp[4] == "Regular") {
							$response .= ",".trim($tmp[0]);
							$response .= ",".trim($tmp[5]);
						}
				}
				fclose($fp);
			} 
			else
			{
				$fp = fopen("./data/testRoute.xls", "rb");
				rewind($fp);
				
				while (!feof($fp)) {
					$string = fgets($fp);
					$tmp = explode("\t", $string);

					if ($tmp[0] == $line_id) {
						$response .= trim($tmp[1]);
				
						if ($tmp [2] == $line_dir) {
							$response .= ",".trim($tmp[3]);
						}
						else
							$response .= ",".trim($tmp[5]);

						$response .= ",".date("Y-m-d",time());
						break;
					}
				}
				fclose($fp);

				if($_week == "0" || $_week == "6")
					$_filename = "./busRoute/".$line_id."/".$_week."/".$line_dir.".xls";
				else
					$_filename = "./busRoute/".$line_id."/".$line_dir.".xls";

				if (file_exists($_filename)) {
					$fp = fopen($_filename, "rb");
					rewind($fp);

					for ($i = 0; !feof($fp); $i++) {
						$string = fgets($fp);
						$tmp = explode("\t", $string);

						if($i == 0)
							for($j=6; $j<count($tmp); $j++)
								if($line_time == $tmp[$j])
								{
									$num = $j;
									break;
								}

						if ($tmp[5] == "Regular") {
							$response .= ",".trim($tmp[1]);
							$response .= ",".trim($tmp[$num]);
						}
					}
					fclose($fp);
				}
			}

			if($mode)
				echo $response;
			else
				return $response;
		} 
		else {
			if($mode)
				echo "No job avaliable today!";
			else
				return NULL;
		}		
	}
	
	function displayDriverRoute()
	{
		$result = loadDriverRoute(false);
		if ($result == NULL) {
			echo "No job avaliable today!";
		} else {
			$str = explode(",", $result);
			echo "<table class='pure-table pure-table-bordered'>";
			for($i=0; $i < count($str);) {
				if ($i == 0) {
					echo "<caption><b>".$str[$i++]."</b></caption>";
				} elseif ($i==1){
					echo "<thead style='text-align:center'> <tr>";
					echo "<th>".$str[$i++]."</th>";
					echo "<th>".$str[$i++]."</th>";	
					echo "</tr> </thead>";
					echo "<tbody>";
				} else {
					echo "<tr>";
					echo "<td>".$str[$i++]."</td>";
					echo "<td>".$str[$i++]."</td>";	
					echo "</tr>";	
				}
			}
			echo "</tbody>";
			echo "</table>";
		}
	}


	if(isset($_GET['refresh']))
	{
		loadDriverRoute(true);
	}
?>