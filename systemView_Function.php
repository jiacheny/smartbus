<?php
	//written by Jiachen Yan
	function selectDate($inputdata) {
		require_once 'database.php';
		$lineID = $inputdata[0];
		$dirID = $inputdata[1];
		$sql = "select distinct date_mel from timetable where line_id=$lineID and dir_id=$dirID";
		$result = getQueryResult($sql);
		$html = "";
		while ($row = mysqli_fetch_assoc($result))
			$html = $html."<option value=".$row['date_mel'].">".$row['date_mel']."</option>";
		echo json_encode($html);
	}
	if (isset($_POST['selectDate'])) { selectDate($_POST['selectDate']); }
	
	
	function getRuns($inputdata) {
		require_once 'database.php';
		$date_mel = $inputdata[0];
		$lineID = $inputdata[1];
		$dirID = $inputdata[2];
		$sql = "select cast(time_mel as time) as time, t.run_id from timetable as t, stopsInOrder as s 
			where date_mel='$date_mel' and t.line_id=$lineID and s.dir_id=$dirID 
				and t.line_id=s.line_id and t.dir_id=s.dir_id and t.stop_id=s.stop_id and order_id=1 
			order by time_mel";
		$result = getQueryResult($sql);
		$html = "";
		while ($row = mysqli_fetch_assoc($result)) {
			$time = substr($row['time'], 0, 5);
			$html = $html."<input type='button' class='pure-button' name=".$row['run_id']."  value='&#xf017; ".$time."'>";
		}
		echo json_encode($html);
	}
	if (isset($_POST['getRuns'])) { getRuns($_POST['getRuns']); }
	
	function viewWorkFlow($inputdata) {
		require_once 'database.php';
		$lineID = $inputdata[0];
		$dirID = $inputdata[1];
		$runDate = $inputdata[2];
		$runID = $inputdata[3];
		$startTime = $inputdata[4];
		$html = "";
		$sql = "select line_number, dir_name from line as l, direction as d where l.line_id=d.line_id and l.line_id=$lineID and dir_id=$dirID";
		$result = getQueryResult($sql);
		$row = mysqli_fetch_assoc($result);
		$html = $html."<h3> <i class='fa fa-bus'></i> ".$row['line_number']." -- To ".$row['dir_name']." </h3>";
		$html = $html."<p style='font-family: Arial, FontAwesome;'> This run (id: $runID) starts at $startTime on &#xf073 $runDate. </p>";
		$html = $html.getOptStopsInfo($inputdata);
		$html = $html.getIndivInfo($lineID, $dirID, $runID, $runDate);
		echo json_encode($html);
	}
	if (isset($_POST['viewWorkFlow'])) { viewWorkFlow($_POST['viewWorkFlow']); }
	
	function getOptStopsInfo($inputdata) {
		
		$lineID = $inputdata[0];
		$dirID = $inputdata[1];
		$runDate = $inputdata[2];
		$runID = $inputdata[3];
		$startTime = $inputdata[4];
		
		$sql1 = "select count(*) as total from stopsInOrder where line_id=$lineID and dir_id=$dirID and regular=0";
		$result = getQueryResult($sql1);
		$row = mysqli_fetch_assoc($result);
		$total = $row['total'];
		
		$sql2 = "select count(*) from stopsInOrder as s, booking as b 
			where s.line_id=$lineID and s.dir_id=$dirID and regular=0 and arrival_time like '%$runDate%' and run_id=$runID
			and s.line_id=b.line_id and s.dir_id=b.dir_id and s.stop_id=b.stop_id";
		$result = getQueryResult($sql2);
		$row = mysqli_fetch_assoc($result);
		$booked = $row['count(*)'];	
			
		$msg="";
		if ($total<=1) {
			$msg = $msg."<p> There is 1 optional stop in this run and $booked is booked. </p>";
		} else {
			if ($booked==0)
				$msg = $msg."<p> There are $total optional stops in this run and none is booked. </p>";
			elseif ($booked==1)
				$msg = $msg."<p> There are $total optional stops in this run and $booked optional stop is booked. </p>";
			else
				$msg = $msg."<p> There are $total optional stops in this run and $booked optional stops are booked. </p>";
		}
		return $msg;
	}
	
	function getIndivInfo ($lineID, $dirID, $runID, $bookDate) {
		$sql = "select b.stop_id, s.location_name
				from booking as b, stopsOpt as s
				where b.stop_id = s.stop_id
					and	line_id = $lineID
					and dir_id = $dirID
					and run_id = $runID
					and arrival_time like '%$bookDate%'
					group by b.stop_id";
		$result = getQueryResult($sql);
		$stopIDs = [];
		while ($row = mysqli_fetch_assoc($result))
			$stopIDs[$row['stop_id']] = $row['location_name'];
		$html = "";
		foreach($stopIDs as $key => $value){
			$count = getCountPassenger ($lineID,$dirID,$runID,$key,$bookDate);
			$locationName = $value;
			if($count<=1)
				$html = $html."<p> <b>$locationName</b> is booked by $count passenger. </p>";
			else
				$html = $html."<p> <b>$locationName</b> is booked by $count passengers.</p>";
		}
		return $html;
	}
	
	function getCountPassenger ($lineID, $dirID, $runID, $stopID, $date){
		$sql ="select count(stop_id)
			   from booking
			   where stop_id = $stopID
			       and dir_id = $dirID
				   and line_id = $lineID
				   and run_id = $runID
				   and arrival_time like '%$date%'";
		$result = getQueryResult($sql);
		while ($row = mysqli_fetch_assoc($result))
			$count = $row['count(stop_id)'];
		return $count;
	}
	
	function loadRegStops ($lineID, $dirID) {
		require_once 'database.php';
		$sql = "select location_name, lat, lon from stopsinorder, stops where stopsinorder.stop_id=stops.stop_id and regular=1 and line_id=$lineID and dir_id=$dirID order by order_id";
		$result = getQueryResult($sql);
		$data = [];
		while ($row = mysqli_fetch_assoc($result))
			array_push($data, [$row['location_name'], floatval($row['lat']), floatval($row['lon'])] );
		echo json_encode($data);
	}
	if (isset($_POST['loadRegStops'])) { loadRegStops($_POST['loadRegStops'][0], $_POST['loadRegStops'][1]); }
	
	function loadOptStopsBooked ($lineID, $dirID, $runDate, $runID) {
		require_once 'database.php';
		$sql = "select distinct location_name, lat, lon from booking as b, stopsOpt as s 
			where line_id=$lineID and dir_id=$dirID and arrival_time like '%$runDate%' and run_id=$runID and b.stop_id=s.stop_id";
		$result = getQueryResult($sql);
		$data = [];
		while ($row = mysqli_fetch_assoc($result))
			array_push($data, [$row['location_name'], floatval($row['lat']), floatval($row['lon'])] );
		echo json_encode($data);
	}
	if (isset($_POST['loadOptStopsBooked'])) { loadOptStopsBooked($_POST['loadOptStopsBooked'][0], $_POST['loadOptStopsBooked'][1], $_POST['loadOptStopsBooked'][2], $_POST['loadOptStopsBooked'][3]); }
	
	function loadOptStopsNotBooked ($lineID, $dirID, $runDate, $runID) {
		require_once 'database.php';
		$sql = "select location_name, lat, lon 
			from stopsInOrder as s1, stopsOpt as s2
			where line_id=$lineID and dir_id=$dirID and regular=0 
				and s1.stop_id=s2.stop_id
				and s1.stop_id not in (
					select distinct b.stop_id 
					from booking as b, stopsOpt as s
					where line_id=$lineID and dir_id=$dirID and arrival_time like '%$runDate%' and run_id=$runID and b.stop_id=s.stop_id)";
		$result = getQueryResult($sql);
		$data = [];
		while ($row = mysqli_fetch_assoc($result))
			array_push($data, [$row['location_name'], floatval($row['lat']), floatval($row['lon'])] );
		echo json_encode($data);
	}
	if (isset($_POST['loadOptStopsNotBooked'])) { loadOptStopsNotBooked($_POST['loadOptStopsNotBooked'][0], $_POST['loadOptStopsNotBooked'][1], $_POST['loadOptStopsNotBooked'][2], $_POST['loadOptStopsNotBooked'][3]); }
	
	
	
	
	
	
	
	
	
?>