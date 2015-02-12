<?php
	
	function shiftWorkFlow($inputdata) {
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
		
		$sql = "select username from shifts as s, driver as d, direction as dir, line as l where run_id=$runID and date_mel='$runDate' and dir.line_id=$lineID and dir.dir_id=$dirID and s.driver_id=d.id and l.line_id=s.line_id";
		$result = getQueryResult($sql);
		if ($row = mysqli_fetch_assoc($result)) {
			$html = $html."<b>".$row['username']."</b> has been allocated to this run.";
		} else {
			$html = $html."No driver has been allocated to this run yet.";
		}
		echo json_encode($html);
	}
	if (isset($_POST['shiftWorkFlow'])) { shiftWorkFlow($_POST['shiftWorkFlow']); }
	
	function getDriver () {
		require_once 'database.php';
		$sql = "select username from driver";
		$result = getQueryResult($sql);
		$html = "";
		while ($row=mysqli_fetch_assoc($result)) {
			$html = $html."<option>".$row['username']."</option>";
		}
		echo json_encode($html);
	}
	if (isset($_POST['getDriver'])) { getDriver(); }

	
?>