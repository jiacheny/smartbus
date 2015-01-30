<?php
	include 'database.php';
	session_start();
	
	//Passenger login function
	function passengerLogin($passengerId, $password) {
		
		$sql = "select count(username) as total from passenger where username='$passengerId' and password='$password'";
		$result = getQueryResult($sql);
		$row = mysqli_fetch_assoc($result);

		$_SESSION['passenger']['status'] = false;
		if ($row['total']==1) {
			$_SESSION['passenger']['id'] = $passengerId;
			$_SESSION['passenger']['status'] = true;
		} 
		else
			throw new customException("Invalid ID or Password!");
	}
	
	//Driver Login
	function driverLogin($driverId,$password) {
		
		$sql = "select count(username) as total from driver where username='$passengerId' and password='$password'";
		$result = getQueryResult($sql);
		$row = mysqli_fetch_assoc($result);
		
		$_SESSION['driver']['status'] = false;
		if ($row['total']==1) {
			$_SESSION['driver']['id'] = $$driverId;
			$_SESSION['driver']['status'] = true;
		}
		else
			throw new customException("Invalid ID or Password!");
	}

	
	
?>