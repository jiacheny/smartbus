<?php
	
	// written by Jiachen Yan
	function showLineRouteNumber() {	
		$file = fopen("data/lineinfo.xls", r);
		rewind($file);

		while(!feof($file)){
			$string = fgets($file); 
			$temp = explode("\t", $string);
			echo "<button class='pure-button'> <i class='fa fa-bus'></i> $temp[1] </button>";
		}
	}
	
	
	
	
	
	
	
	
	
?>