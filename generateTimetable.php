<!--writen by ran jing  -->
<?php
	require_once("API_Function.php");
?>
<!DOCTYPE html>
<html>

<head>
	<title> TESTING FOR TIMETABLE 905</title>
	<script type="text/javascript">
		console.log("HELLO");
	</script>
</head>

<body>


	<div> 
		<?php
			
			generateTimetable(7474,34,date('Y-m-d\TH:i:s\Z'));				
		?>

	</div>

	

</body>


</html>