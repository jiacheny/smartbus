<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/mystyle.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <title>Home Page</title>
</head>

<body>

	<div style="background-color: white">
		<?php include './include/top.inc';?>
	
		<main>
		
		    <div id="introduction">
		        <h1>Introduction:</h1>
		
				<p>SmartBus routes undergo 'bus-friendly' roadwork to improve reliability and the way buses move in and out of traffic. Bus lanes are introduced in high-delay locations and in some areas SmartBus buses have the ability to request traffic light priority.</p>
				<p>New technology gives SmartBus buses the ability to communicate with their depot during a journey, and to provide real-time travel information to passengers at selected high-use bus stops. Bus-train interchanges also have signs with real-time information on SmartBus and train arrival times, making journey transitions smoother.</p>
				<p>Bus stops along SmartBus routes are safer and are highly visible, because they have been designed to the Commonwealth Disability Discrimination Act (DDA) standards.</p>
				<p>SmartBus stops feature tactile ground surface indicators and high contrast colour schemes that are used to meet the needs of people with a vision impairment. All SmartBus stops provide local area maps and stop specific timetables.</p>
				<p>Low-floor buses are used on SmartBus routes. These buses are able to ‘meet’ the bus stop at the same level and eliminate a ‘step’ to board the bus.</p>
				
		    </div>
		    
		    <div id="routetable">
		    	<table>
			    	<caption> <h1> Current Available Routes </h1> </caption>
			    	<tr>
				    	<td> 703 </td> <td> 900 </td> <td> 901 </td>
			    	</tr>
			    	<tr>
				    	<td> 902 </td> <td> 903 </td> <td> 905 </td>
			    	</tr>
			    	<tr>
				    	<td> 906 </td> <td> 907 </td> <td> 908 </td>
			    	</tr>
			    	
		    	</table>
		    </div>
		    
		</main>
		
		<?php include './include/footer.inc';?>
	</div>
    
</body>
</html>
