<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/mystyle.css">

    <title>Home Page</title>
</head>

<body>
	
	<div style="background-color: white">
	
	    <?php include './include/top.inc';?>
	
	    <div id="about1">
	        <p><b>There are 4 functions for this Project.</b></p>
	
	        <p><b>Passenger view:</b><br>
	        After login, user can make a booking by select route, direction and<br>
	        time. Choosing the destination and submit.<br>
	        The file name will save as date of the booking: yyyymmddhhii.xls<br>
	        y - A four digit representation of a year<br>
	        m - A numeric representation of a month (from 01 to 12)<br>
	        d - The day of the month (from 01 to 31)<br>
	        h - 24-hour format of an hour (00 to 23) for the first destination of route<br>
	        i - Minutes with leading zeros (00 to 59) for the first destination of route<br>
	        Passenger Account:<br>
	        Username: P001 Password: 12345<br>
	        Username: P002 Password: 12345<br></p>
	    </div>
	
	    <div id="about2">
		    <br>
		    <br>
	        <p><b>Driver view:</b><br>
	        Driver view shows the job that driver current doing.<br>
	        If the time for next destination is in 5 mins. The<br>
	        background of that one will become red.<br>
	        Driver Account:<br>
	        Username: D001 Password: 12345<br>
	        Username: D002 Password: 12345<br></p>
	
	        <p><b>System view:</b><br>
	        If there are any job for an route is existing. User can see the map for<br>
	        that job by click the route, direction and one of the job.</p>
	    </div>
	    
	    <?php include './include/footer.inc';?>
    
	</div>
</body>
</html>
