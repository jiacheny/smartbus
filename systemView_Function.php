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

		$sql = "select cast(time_mel as time) as time from timetable as t, stopsInOrder as s 
			where date_mel='$date_mel' and t.line_id=$lineID and s.dir_id=$dirID 
				and t.line_id=s.line_id and t.dir_id=s.dir_id and t.stop_id=s.stop_id and order_id=1 
			order by time_mel";
		$result = getQueryResult($sql);
		$html = "";
		while ($row = mysqli_fetch_assoc($result)) {
			$time = substr($row['time'], 0, 5);
			$html = $html."<input type='button' class='pure-button' value='&#xf017; ".$time."' style='font-family: Arial, FontAwesome; background-color: white; width: 30%;'>";
		}
		echo json_encode($html);
	}
	if (isset($_POST['getRuns'])) { getRuns($_POST['getRuns']); }
	
	
	
	
	
?>