<?php

	function getDirectionID ( $lineID ) {
		$directionIDArray = [];
		if (file_exists("./data/lineDirectionID.xls")) {
			$fp = fopen("./data/lineDirectionID.xls", "rb");
			rewind($fp);
			while(!feof($fp)){
				$string = fgets($fp); //gets line from file pointer
				$temp = explode("\t", $string);
				$tempLineID = $temp[0];
				if ($tempLineID == $lineID) {
					$directionIDArray[$temp[2]] = [];
					$directionIDArray[$temp[4]] = [];
					fclose($fp);
					return $directionIDArray;
				};
			}
		} else {
			throw new customException("File not found!");
		}
		fclose($fp);
		throw new customException("No such Line ID exists");
	}

	function readOptionalStopFile ( $lineID ) {
		$stopLocationArray = [];
		if (file_exists("./data/stops/optional/".$lineID.".xls")) {
			$fp = fopen("./data/stops/optional/".$lineID.".xls", "rb");
			rewind($fp);
			while(!feof($fp)){
				$string = fgets($fp); //gets line from file pointer
				$temp = explode("\t", $string);
				$temp[2] = trim($temp[2]);
				$tempArray = [$temp[0], $temp[1], $temp[2]];
				array_push($stopLocationArray,$tempArray);
			}
			return $stopLocationArray;
		} else {
			throw new customException("File not found!");
		}
		fclose($fp);
		throw new customException("No such Line ID exists");
	}







?>