<?php
	session_start();
	//Passenger login function
	function passengerLogin($passengerId,$password)
	{
		//Set the status = false
		$_SESSION['passenger']['status'] = false;
		
		//Check file is exists
		if(file_exists("./account/passengerList.xls"))
		{
			//Open file
			$fp = fopen("./account/passengerList.xls","rb");
			rewind($fp);
			
			//Check if the id valid or not
			while(!feof($fp))
			{
				$string = fgets($fp);
				$tmp = explode("\t",$string);
				
				if($passengerId == $tmp[0])
				{
					if(trim($password) == trim($tmp[1]))
					{
						$_SESSION['passenger']['id'] = $tmp[0];
						$_SESSION['passenger']['status'] = true;
					}
				}
			}
			
			//Close file
			fclose($fp);
			
			//if invalid throw exception
			if($_SESSION['driver']['status'] == false)
				throw new customException("Invalid ID or Password!");
		}
		else
			throw new customException("File not found!");
	}
?>