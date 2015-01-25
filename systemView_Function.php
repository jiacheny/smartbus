<?php
	
	// written by Jiachen Yan
	function showLineRouteNumber() {	
		$file = fopen("data/lineinfo.xls", r);
		rewind($file);
		while(!feof($file)){
			$string = fgets($file); 
			$temp = explode("\t", $string);
			echo "<button class='pure-button' > <i class='fa fa-bus'></i> $temp[1] </button>";
		}
	}
	
	//written by Jiachen Yan
	function getDirectionInfo($routeNumber) {
		$file = fopen("data/lineinfo.xls", r);
		rewind($file);
		$dirinfo = "";
		while(!feof($file)){
			$string = fgets($file); 
			$temp = explode("\t", $string);
			if ($temp[1]==$routeNumber) {
				$dirinfo = "<p> $temp[4] </p> <p> $temp[6] </p>";
			}
		}
		echo json_encode($dirinfo);
	}
	
	if (isset($_POST['getDirectionInfo'])) {
        getDirectionInfo($_POST['getDirectionInfo']);
    }
	
	
	
	
	
	
?>