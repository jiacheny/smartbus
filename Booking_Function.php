<?php
	session_start();
	
	//written by Jiachen Yan
	function selectLineNumber() {
		$sql = "select * from line order by line_number";
		$result = getQueryResult($sql);
		$html = "";
		while ($row=mysqli_fetch_assoc($result)) {
			$html = $html."<option value=".$row['line_id']." >".$row['line_number']."</option>";
		}
		echo $html;
	}
	
	//written by Jiachen Yan
	function selectDirection ($lineID) {
		require_once('database.php');
		$sql = "select dir_id, dir_name from direction where line_id=$lineID";
		$result = getQueryResult($sql);
		$html = "<option> Select A Direction </option>";
		while ($row=mysqli_fetch_assoc($result)) {
			$html = $html."<option value=".$row['dir_id']."> To ".$row['dir_name']." </option>";
		}
		echo json_encode($html);
	}
	if (isset($_POST['selectDirection'])) { selectDirection($_POST['selectDirection']); }
	
	//written by Jiachen Yan
	function selectStops ($data) {
		$lineID = $data[0];
		$dirID = $data[1];
		require_once('database.php');
		$sql = "select stopsOpt.stop_id, location_name from stopsInOrder, stopsOpt where regular=0 and line_id=$lineID and dir_id=$dirID and stopsInOrder.stop_id=stopsOpt.stop_id order by order_id";
		$result = getQueryResult($sql);
		$html = "<option> Select An Optional Stop </option>";
		while ($row=mysqli_fetch_assoc($result)) {
			$html = $html."<option value=".$row['stop_id']."> ".$row['location_name']." </option>";
		}
		echo json_encode($html);
	}
	if (isset($_POST['selectStops'])) { selectStops($_POST['selectStops']); }
	
	function timetableWorkflow ($inputdata){
		
		date_default_timezone_set("UTC");
		require_once('database.php');
		require_once('API_Function.php');
		$lineID = $inputdata[0];
		$dirID = $inputdata[1];
		$optID = $inputdata[2];
		$bookingTime = $inputdata[3];
		$bookingTimeStr = strtotime($bookingTime);
		$bookingUTCTime = date("Y-m-d\TH:i:s\Z",$bookingTimeStr);
		$html = "";
		
		$check = checkTimetable ($lineID, $dirID, $bookingTime); 
		
		if($check){
			$html = displayTimetable($lineID, $dirID, $optID, $bookingTime);
		} else {			
			generateTimetable($lineID, $dirID, $bookingUTCTime);
			$html = displayTimetable($lineID, $dirID, $optID, $bookingTime);
		}
		
		echo json_encode($html);
	}
	if (isset($_POST['timetableWorkflow'])) {timetableWorkflow($_POST['timetableWorkflow']); }
	
	//written by Ran Jing
	function displayTimetable($lineID, $dirID, $optID, $bookingTime){
		
		//require_once('API_function.php');
		/*$lineID = $inputdata[0];
		$dirID = $inputdata[1];
		$optID = $inputdata[2];
		$bookingTime = $inputdata[3];*/
		date_default_timezone_set("UTC");
		$html = "";
		$conn = createConnection ();
		$bookingUTCTime = date("Y-m-d\TH:i:s\Z",strtotime($bookingTime));
		
		$temptime = strtotime($bookingTime);
		$starttime = date('Y-m-d H:i:s',strtotime('-15 minutes', $temptime));
		
		$endtime = date('Y-m-d H:i:s',strtotime('+60 minutes', $temptime));
		
		
		$sql = "select stop_id from stopsInOrder where dir_id=$dirID and line_id=$lineID order by order_id";
		$result = getQueryResult($sql);
		$stopIDs = [];
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($stopIDs, $row['stop_id']);
		}
		
		$sql = "select run_id from timetable where line_id = $lineID and dir_id = $dirID 
				and time_mel < '$endtime'
				and time_mel > '$starttime'
				and stop_id in (select stop_id
								from stopsInOrder
								where order_id in (select order_id-1
													from stopsInorder
													where line_id = $lineID
													and dir_id = $dirID
													and stop_id = $optID )				
				)
				order by time_mel";
		$result = getQueryResult($sql);
		$runIDs = [];
		while ($row = mysqli_fetch_assoc($result) ) {
			if (!in_array($row['run_id'], $runIDs))
				array_push($runIDs, $row['run_id']);
		}

		//display timetable
		
		$html = "<br><table class='pure-table pure-table-bordered'>";
		foreach ($stopIDs as $key => $value) {
			$html = $html."<tr>";
			$html = $html."<td>".getStopName($lineID,$dirID,$value)."</td>";
			$tempStopID = $value;
			foreach ($runIDs as $key2 => $value2) {
				$sql = "select t.stop_id, run_id, time_mel from timetable as t, stops as s where t.stop_id=s.stop_id and t.stop_id=$value and run_id=$value2";
				$result = getQueryResult($sql);
				if ($row = mysqli_fetch_assoc($result)) {					
					$tempTime = $row['time_mel'];
					$tempTime = date("Y-m-d\TH:i:s\Z", strtotime($tempTime));
					
					$html = $html."<td style='text-align: center'>".$tempTime."</td>";
				} else {
					if($tempStopID == $optID){
						$preStopTime = getPreStopTime($lineID,$dirID,$value2,$optID);
						//$preStopTime = date("H:i", strtotime($preStopTime));
						$html = $html."<td style='text-align: center; background-color: #cc0000; color: white'><label><input class='optCheckbox' type='checkbox' name=$value2 value='$preStopTime'> ".date("Y-m-d\TH:i:s\Z", strtotime($preStopTime))."</label></td>";		
					}
					else $html = $html."<td style='text-align: center'> --- </td>";
				}
			}
			$html = $html."</tr>";
		}
		$html = $html."</table> <br> <input id='bookChecked' type='button' class='pure-button pure-button-primary' value='Book Selected Stop(s)'> <br>";
		return $html;
	}
 	
 	
 	function checkTimetable ($lineID, $dirID, $time){
	 	
	 	require_once("database.php");
		
		$check = 0;
		$conn = createConnection ();
	
		$sql = "select distinct date_mel from timetable";

		$result = getQueryResult($sql);
		$tempDate = [];
		while($row = mysqli_fetch_assoc($result)){
			
			$temp = $row['date_mel'];
			
			array_push($tempDate, $temp);
		}
		
		$checkDate = date('Y-m-d',strtotime($time));
		
		foreach($tempDate as $key => $value){
	
			
			$haveDate = $value;
			if($checkDate == $haveDate){
				$check = 1;
				continue ;
			}
		
			$check = 0;
		
		}
	
		return $check;
	
	}
	
	
	//written by Ran Jing
	function getStopName ($lineID,$dirID,$stopID) {
		require_once('database.php');
		$sql = "select regular from stopsInOrder where line_id = $lineID and dir_id = $dirID and stop_id = $stopID";
		$result = getQueryResult($sql);
		$row = mysqli_fetch_assoc($result);
		$type = $row['regular'];
		if($type == 1){
			$sql = "select location_name from stops where stop_id=$stopID";
			$result = getQueryResult($sql);
			$row = mysqli_fetch_assoc($result);
			$stopName = $row['location_name'];
			return $stopName;
		}
		elseif($type == 0){
			$sql = "select location_name from stopsOpt where stop_id=$stopID";
			$result = getQueryResult($sql);
			$row = mysqli_fetch_assoc($result);
			$stopName = $row['location_name'];
			return $stopName;
		}
	}
	
	//written by Ran Jing
	function getPreStopTime($lineID,$dirID,$runID,$optID){	
		require_once('database.php');
		$sql = "select time_mel from timetable where line_id = $lineID and dir_id = $dirID 
				and run_id = $runID
				and stop_id in ( select stop_id
						 	from stopsInOrder
						 	where order_id in ( select order_id-1
						 						from stopsInorder
						 						where line_id = $lineID
						 						and dir_id = $dirID
						 						and stop_id = $optID
						 )
		)";
		$result = getQueryResult($sql);
		$row = mysqli_fetch_assoc($result);
		$preStopTime = $row['time_mel'];
		return $preStopTime;
	}

	/*function sortTimetable($lineID,$dirID,$runID,){
		
		$sql = "select time_mel, run_id
			from timetable
			where line_id = $lineID
				and dir_id = $dirID
				and stop_id in (select stop_id 
								from lineStopsOrder 
								where line_id = $lineID 
								and dir_id = $dirID 
								and order_id = 1
								)
			order by time_mel					
		";
		$result = getQueryResult($sql);
		$row = mysqli_fetch_assoc($result);
		$orderRunID = $row['run_id'];
		$return $orderRunID;
	}*/




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

	//written by Jiachen Yan
	function createBooking($inputdata) {
		
		require_once('database.php');
		
		$passengerUsername = $_SESSION['passenger']['username'];
		$lineID = $inputdata[0];
		$dirID = $inputdata[1];
		$stopID = $inputdata[2];
		$runID = $inputdata[3];
		$arrivaltime = $inputdata[4];
		$bookingTime_utc = date("Y-m-d\TH:i:s\Z");

		$sql1 = "select * from passenger where username='$passengerUsername'";
		$result = getQueryResult($sql1);
		$html ="";
		while ($row = mysqli_fetch_assoc($result)) {
			$passengerid = $row['id'];
			$passengerid = 9;
			$sql2 = "INSERT INTO booking (passenger_id, line_id, dir_id, stop_id, run_id, arrival_time, booking_time) VALUES ($passengerid, $lineID, $dirID, $stopID, $runID, '$arrivaltime', '$bookingTime_utc')";
			$conn = createConnection ();
			if(mysqli_query($conn, $sql2)) {
				$html = $html."<p> The stop $stopID at ".date("H:i", strtotime($arrivaltime))." is booked successful.  </p>";
			} else {
				$html = $html."<p style='color: rgb(202, 60, 60);'> The stop $stopID at ".date("H:i", strtotime($arrivaltime))." is booked unsuccessful.  </p>";
			}
		}
		echo json_encode($html);
	}
	if (isset($_POST['createBooking'])) { createBooking($_POST['createBooking']); }
?>