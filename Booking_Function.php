<?php
	session_start();
	
	//written by Jiachen Yan
	function selectLineNumber() {
		$sql = "select line_number from line order by line_number";
		$result = getQueryResult($sql);
		$html = "";
		while ($row=mysqli_fetch_assoc($result)) {
			$html = $html."<option>".$row['line_number']."</option>";
		}
		echo $html;
	}
	
	
	
	//load search route
	function loadRoute($line_id,$linedir_id,$date,$_time) {
		$_week = date("w",strtotime($date));
		//set the file path
		if($_week == "0" || $_week == "6")
			$_filename = "./busRoute/".$line_id."/".$_week."/".$linedir_id.".xls";
		else
			$_filename = "./busRoute/".$line_id."/".$linedir_id.".xls";
		//check file
		if(file_exists($_filename)) {
			//open file
			$fp = fopen($_filename,"rb");
			rewind($fp);
			
			$num = NULL;
			//load data
			for($i=0; !feof($fp); $i++) {
				$string = fgets($fp);
				$tmp = explode("\t",$string);
				
				$result[$i]['location_name'] = trim($tmp[1]);
				$result[$i]['stop_id'] = trim($tmp[0]);
				$result[$i]['lat'] = trim($tmp[3]);
				$result[$i]['lon'] = trim($tmp[4]);
				$result[$i]['status'] = trim($tmp[5]);
				
				if($i == 0) {
					for($j=6; $j<count($tmp); $j++) {
						if(strtotime(trim($tmp[$j])) >= strtotime($_time)) {
							$num = $j;
							break;
						}
					}
					if($num == NULL)
						throw new customException("No available at this time!");
				}
				$result[$i]['time'] = str_replace(PHP_EOL, '',trim($tmp[$num]));
			}
			fclose($fp);
			
			$_filename = "./schedule/".$line_id."/".$linedir_id."/".date("Ymd",strtotime($date)).date("Hi",strtotime($result[0]['time'])).".xls";
			
			if(file_exists($_filename)) {
				$fp = fopen($_filename,"rb");
				rewind($fp);
				$string = fgets($fp);

				for($i=0; !feof($fp); $i++)
				{
					$string = fgets($fp);
					if($string == NULL) break;
					$tmp = explode("\t",$string);
					
					$result[$i]['status'] = trim($tmp[4]);
				}
				fclose($fp);
			}
			$_SESSION['result'] = $result;
		}
		else
			throw new customException("File not Found!");
	}
	
	//display the search result
	function displaySearchRoute()
	{
		//check if it is NULL or not
		if(isset($_SESSION['result']) && $_SESSION['result'] != NULL)
		{
			//For each result, display the location name, destination name and time.
			for($i=0; $i<count($_SESSION['result']); $i++)
			{
				echo "<tr>";
				echo "<td>";
				echo $_SESSION['result'][$i]['location_name'];
				echo "</td>";
				echo "<td>";
				$_select = $_SESSION['result'][$i]['stop_id'];
				echo "<input type='checkbox' name='bookStop[]' value='$_select'";
				if($_SESSION['result'][$i]['status'] != "Optional"){echo " disabled";}
				echo "/>";
				echo $_SESSION['result'][$i]['time'];
				echo "</td>";
				echo "<td>";
				echo $_SESSION['result'][$i]['status'];
				echo "</td>";
				echo "</tr>";
			}
		}
		else
			throw new customException("Empty Search Result!");
	}

	//insert booking
	function insertBooking($_select)
	{
		//define file name
		$_filename = "./schedule/".$_SESSION['line_id']."/".$_SESSION['linedir_id']."/".date("Ymd",strtotime($_SESSION['date'])).date("Hi",strtotime($_SESSION['result'][0]['time'])).".xls";
		$_rela_station = "./busRoute/".$_SESSION['line_id']."/relation.xls";

		$fp = fopen($_filename,"wb");

		$fptr = fopen("./data/testRoute.xls", "rb");
		rewind($fptr);
		while (!feof($fptr)) {
			$string = fgets($fptr);
			$tmp = explode("\t", $string);

			if ($tmp[0] == $_SESSION['line_id']) {
				fputs($fp,$tmp[1]."\t");
				if ($tmp [2] == $_SESSION['linedir_id']) {
					fputs($fp,$tmp[3].PHP_EOL);
				}
				else
					fputs($fp,$tmp[5].PHP_EOL);
			}
		}
		fclose($fptr);

		$fptr = fopen($_rela_station, "rb");
		for($i=0; $i<(count($_SESSION['result'])); $i++)
		{
			$change = false;
			for($j=0; $j<count($_select); $j++)
			{
				rewind($fptr);
				while(!feof($fptr))
				{
					$string = fgets($fptr);
					$tmp = explode("\t", $string);

					if($_select[$j] == $tmp[0])
					{		
						if(strstr($tmp[1],$_SESSION['result'][$i]['stop_id']) != false)
							$change = true;
						break;
					}
				}
			}
			foreach($_SESSION['result'][$i] as $key => $value)
			{
				if($key == "status" && $change == true)
					$value = "Regular";
				if($key != "time")
					fputs($fp,$value."\t");
				elseif ($i == count($_SESSION['result'])-1) {
					fputs($fp,$value);
				}
				else
					fputs($fp,$value.PHP_EOL);
			}
		}
		fclose($fptr);
		fclose($fp);
	}

	//change direction drop-down box
	function changeDir()
	{
		//check the file
		if(file_exists("./data/testRoute.xls"))
		{
			//open file
			$fp = fopen("./data/testRoute.xls","rb");
			rewind($fp);
			
			//read file and load data
			while(!feof($fp))
			{
				$string = fgets($fp);
				$tmp = explode("\t",$string);
				
				if($tmp[0] == $_GET['route'])
				{
					$option[0] = $tmp[2];
					$option[1] = $tmp[3];
					$option[2] = $tmp[4];
					$option[3] = $tmp[5];
					break;
				}
			}
			//set the response
			$response = "(Select Direction),".$option[0].",".$option[1].",".$option[2].",".$option[3];
		}
		else
			die("File not found!");
		//output the response
		echo $response;
	}
	
	//if the Route Selection onchange, call changeDir() function
	if(isset($_GET['route']))
	{
		changeDir();
	}

?>